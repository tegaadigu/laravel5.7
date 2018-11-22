<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  protected $fillable = [
    'first_name',
    'last_name',
    'salary',
    'hire_date',
    'is_active',
  ];

  /**
   * One to one relationShip with position
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function position() {
    return $this->belongsTo(Position::class);
  }

}
