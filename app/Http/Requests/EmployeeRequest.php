<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      //Should add check for user but for now just allow anyone to edit request.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
        'first_name' => 'required',
        'last_name' => 'required',
        'salary' => 'required|numeric',
        'hire_date' => 'required|date',
        'position_id' => 'required|integer',
        'is_active' => 'required|boolean',
      ];
    }
}
