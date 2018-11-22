<?php

namespace App\Model;

use App\Position;

class Salary
{
  /**
   * @param float $salary
   * @param Position $position
   *
   * @return bool
   */
  public static function isWithinRange(float $salary, Position $position) : bool {
    return $salary >= $position->salary_min && $salary <= $position->salary_max;
  }
}
