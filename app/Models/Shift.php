<?php

namespace App\Models;

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
}
