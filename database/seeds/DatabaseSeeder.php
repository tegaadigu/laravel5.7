<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      //create position and link with employee using faker
      factory(\App\Position::class, 10)->create()->each(function ($position) {
        $position->employee()->save(factory(\App\Employee::class)->make());
      });
    }
}
