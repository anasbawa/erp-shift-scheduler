<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftRequest extends Model
{
    use HasFactory;

    protected $fillable = ['shift_id', 'employee_id', 'status', 'reserved_at'];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
