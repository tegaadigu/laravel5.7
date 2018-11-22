<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'first_name' => $this->first_name,
          'last_name' => $this->last_name,
          'position' => $this->position,
          'salary' => $this->salary,
          'position_id' => $this->position_id,
          'created_at' => $this->created_at->format('Y-m-d H:i:s'),
          'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
          'hire_date' => $this->hire_date,
          'is_active' => $this->is_active,
        ];
    }
}
