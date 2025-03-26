<?php

namespace App\Http\Controllers;

use App\Enums\RequestStatusEnum;
use App\Http\Resources\ShiftRequestResource;
use App\Models\Resource;
use App\Models\Shift;
use App\Models\ShiftRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftRequestController extends Controller
{
    public function createRequest(Request $request, Shift $shift)
    {
        $employee = User::find($request->employee_id);
        $resource = Resource::find($request->resource_id);

        DB::beginTransaction();
        try {

            // Lock Shift Record
            $shift = Shift::where('id', $shift->id)->lockForUpdate()->first();

            // 1. Check for overlapping shifts
            $overlap = ShiftRequest::checkOverlap($shift->id, $employee->id);
            if ($overlap) {
                DB::rollBack();
                return response()->json(['error' => 'Cannot join overlapping shifts'], 400);
            }

            // 2. Check if there are enough resources available
            if (!$shift->hasAvailableResources()) {
                DB::rollBack();
                return response()->json(['error' => 'Not enough resources available'], 400);
            }

            // 3. Create the shift request
            $shiftRequest = ShiftRequest::create([
                'employee_id' => $request->employee_id,
                'shift_id' => $request->shift_id,
                'status' => RequestStatusEnum::Pending,
            ]);

            // 4. Reserve a Resource
            $resource->employee_id = $employee->id;
            $resource->save();

            DB::commit();

            return response()->json([
                'message' => 'Shift requested successfully',
                'shift_request' => new ShiftRequestResource($shiftRequest)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to request shift'], 500);
        }
    }

    public function approveShiftRequest(ShiftRequest $shiftRequest)
    {
        // Approve the shift request
        $shiftRequest->status = RequestStatusEnum::Approved;
        $shiftRequest->save();

        return response()->json($shiftRequest, 200);
    }

    public function rejectShiftRequest(ShiftRequest $shiftRequest)
    {
        // Reject the shift request
        $shiftRequest->status = RequestStatusEnum::Rejected;
        $shiftRequest->save();

        $resource = Resource::where('shift_id', $shiftRequest->shift_id)
        ->where('employee_id', $shiftRequest->employee_id)
        ->first();

        // Release the Resource
        $resource->employee_id = null;
        $resource->reserved_at = null;
        $resource->save();

        return response()->json($shiftRequest, 200);
    }
}
