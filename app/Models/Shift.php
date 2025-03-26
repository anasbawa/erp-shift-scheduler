<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'start_time', 'end_time', 'max_employees'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function requests()
    {
        return $this->hasMany(ShiftRequest::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    // Check if there are enough available resources for the shift
    public function hasAvailableResources()
    {
        // Calculate the current number of resources in use
        $resourcesInUse = $this->resources()->whereNotNull('employee_id')->count();

        // Check if there are enough resources
        return $resourcesInUse < $this->max_employees;
    }

    // Relationship with shift requests
    public function shiftRequests()
    {
        return $this->hasMany(ShiftRequest::class);
    }
}
