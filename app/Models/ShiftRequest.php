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

    // Check if the shift overlaps with existing requests for the same employee
    public static function checkOverlap($shiftId, $employeeId)
    {
        $shift = Shift::find($shiftId);

        // Check if employee already has any overlapping shifts
        $overlappingShifts = self::where('employee_id', $employeeId)
            ->whereHas('shift', function($query) use ($shift) {
                $query->where(function($query) use ($shift) {
                    // Check for overlapping shifts
                    $query->whereBetween('start_time', [$shift->start_time, $shift->end_time])
                          ->orWhereBetween('end_time', [$shift->start_time, $shift->end_time])
                          ->orWhere(function($query) use ($shift) {
                              $query->where('start_time', '<', $shift->start_time)
                                    ->where('end_time', '>', $shift->end_time);
                          });
                });
            })
            ->exists();

        return $overlappingShifts;
    }
}
