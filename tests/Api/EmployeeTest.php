<?php

namespace Tests\Api;

use Carbon\Carbon;
use Tests\TestCase;

class EmployeeTest extends TestCase
{

  public function setup()
  {
    parent::setup();
    //Seed database first.. before running test.
    $this->artisan('db:seed');
    $this->endpoint = 'api/employee/';
  }

  /**
   * A basic test example.
   *
   * @return void
   */
  public function testGetAllEmployees()
  {
    $response = $this->get($this->endpoint);

    $response->assertStatus(200);
  }

  /**
   * Getting a specific employee id
   * This test assumes you have seeded the database
   *
   * @test
   * @return void
   */
  public function GetEmployeeWithId() {
    $response = $this->get($this->endpoint);
    $employee = $response->json()[0];
    $response = $this->get($this->endpoint.$employee['id']);

    $this->assertEquals($employee, $response->json()['data']);
  }


  /**
   * Update an employee with Invalid Datasets
   * This test assumes you have seeded the database
   *
   * @test
   * @return void
   */
  public function updateEmployeeWithValidData()
  {
    $response = $this->get($this->endpoint);
    $employee = $response->json()[0];
    $data = [
      'first_name' => 'Tega',
      'last_name' => 'Adigu',
      'salary' => 80000,
      'hire_date' => (new Carbon())->format('Y-m-d H:i:s'),
      'position_id' => $employee['position_id'],
      'is_active' => true,
    ];
    $response = $this->putJson($this->endpoint.$employee['id'], $data);

    $updatedEmployee = $response->json()['data'];

    $this->assertEquals($data['first_name'], $updatedEmployee['first_name']);
    $this->assertEquals($data['last_name'], $updatedEmployee['last_name']);
    $this->assertEquals($data['salary'], $updatedEmployee['salary']);
  }

  /**
   * Update an employee with salary range lower than 80000
   * This test assumes you have seeded the database
   *
   * @test
   * @return void
   */
  public function updateEmployeeWithLowerSalaryRange()
  {
    $response = $this->get($this->endpoint);
    $employee = $response->json()[0];
    $data = [
      'first_name' => 'Tega',
      'last_name' => 'Adigu',
      'salary' => 40000,
      'hire_date' => (new Carbon())->format('Y-m-d H:i:s'),
      'position_id' => $employee['position_id'],
      'is_active' => true,
    ];
    $response = $this->putJson($this->endpoint.$employee['id'], $data);

    $this->assertEquals('salary doesnt fall under position range.', $response->json());

  }
}
