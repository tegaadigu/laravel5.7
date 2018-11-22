<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

  /**
   * Although not stated in the task
   * adding a salary range for a particular position.
   *
   * e.g Senior Dev - range 80 - 100 k
   * if a salary falls below this range an error will be triggered.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'salary_min',
    'salary_max',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function employee() {
    return $this->hasMany(Employee::class);
  }
}
