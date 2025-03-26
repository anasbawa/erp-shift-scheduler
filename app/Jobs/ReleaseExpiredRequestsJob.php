<?php

namespace App\Jobs;

use App\Enums\RequestStatusEnum;
use App\Models\Resource;
use App\Models\ShiftRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReleaseExpiredRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info("Running ...");

        // Get all expired shift requests
        $expiredShifts = ShiftRequest::where('status', RequestStatusEnum::Pending)
        ->where('reserved_at', '<', now()->subMinutes(5))
        ->get();

        if ($expiredShifts->isEmpty()) {
            Log::info("No expired shift reservations found.");
            return;
        }

        foreach ($expiredShifts as $shift) {
            // Reject the expired request
            $shift->update(['status' => RequestStatusEnum::Rejected]);
            Log::info("Rejected shift request ID: " . $shift->id);

            // Release the related resource
            $resource = Resource::where('shift_id', $shift->id)
                ->where('employee_id', $shift->employee_id)
                ->first();

            if ($resource) {
                $resource->update([
                    'employee_id' => null,
                    'reserved_at' => null,
                ]);
                Log::info("Released resource ID: " . $resource->id);
            }
        }

        Log::info("Completed ...");
    }
}
