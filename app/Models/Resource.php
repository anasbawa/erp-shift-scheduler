<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = ['shift_id', 'employee_id', 'title'];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
