<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Model\Salary;
use App\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   *
   * @return JsonResponse
   */
  public function index(Request $request) : JsonResponse
  {
    $employee = Employee::with('position')->get();
    return response()->json($employee);
  }

  /**
   *
   * Show Employee based on passed id
   *
   * @param int $id
   *
   * @return EmployeeResource
   */
  public function show(int $id)
  {
    $employee = Employee::find($id);
    if(!$employee) {
      return response()->json('employee not found');
    }
    return new EmployeeResource($employee);
  }

  /**
   *
   * Creates a new Employee
   *
   * @param EmployeeRequest $request
   *
   * @return EmployeeResource
   */
  public function store(EmployeeRequest $request) : EmployeeResource
  {
    $validated = $request->validated();
    $position = Position::find($validated['position_id']);
    if(!$position) {
      return response()->json('invalid position id');
    }

    $salary = $validated['salary'];
    if (Salary::isWithinRange($salary, $position) === false) {
      return response()->json('salary doesnt fall under position range.');
    }

    $employee = $this->validateAndSave($validated, new Employee(), $position);

    return new EmployeeResource($employee);
  }

  /**
   *
   * Update an existing employee
   *
   * @param EmployeeRequest $request
   * @param int $id
   *
   * @return EmployeeResource|JsonResponse
   */
  public function update(EmployeeRequest $request, int $id)
  {
    $validated = $request->validated();
    $employee = Employee::with('position')->find($id);
    if(!$employee) {
      return response()->json('invalid employee id');
    }

    $salary = $validated['salary'];
    if (Salary::isWithinRange($salary, $employee->position) === false) {
      return response()->json('salary doesnt fall under position range.');
    }

    $employee = $this->validateAndSave($validated, $employee, $employee->position);

    return new EmployeeResource($employee);
  }

  /**
   * Deletes Employee
   *
   * @param int $id
   *
   * @return JsonResponse
   */
  public function destroy(int $id) : JsonResponse
  {
    $employee = Employee::with('position')->findOrFail($id);
    $employee->delete();

    return response()->json('{}');
  }

  /**
   *
   * Validates salary and store updated / new employee
   *
   * @param array $validatedInput
   * @param Employee $employee
   * @param Position $position
   *
   * @return Employee
   */
  private function validateAndSave(array $validatedInput, Employee $employee, Position $position) : Employee {
    $employee->first_name = $validatedInput['first_name'];
    $employee->last_name = $validatedInput['last_name'];
    $employee->salary = $validatedInput['salary'];
    $employee->hire_date = $validatedInput['hire_date'];
    $employee->is_active = $validatedInput['is_active'];
    $position->employee()->save($employee);

    return $employee;
  }

}
