<?php

use Faker\Generator as Faker;


$factory->define(App\Employee::class, function (Faker $faker) {
  return [
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'salary' => 80000,
    'hire_date' => new Carbon\Carbon(),
    'is_active' => true,
  ];
});
