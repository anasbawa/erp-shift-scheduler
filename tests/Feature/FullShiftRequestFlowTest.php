<?php

namespace Tests\Feature;

use App\Enums\RequestStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Department;
use App\Models\Shift;
use App\Models\ShiftRequest;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FullShiftRequestFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_shift_request_flow()
    {
        $department = Department::factory()->create();

        // Step 1: Create a Manager
        $manager = User::factory()->createOne(['role' => UserRoleEnum::Manager]);

        // Step 2: Create a Shift
        $shiftData = [
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '11:00',
            'max_employees' => 3
        ];

        $response = $this->actingAs($manager)->postJson('/api/shifts', $shiftData);
        $response->assertStatus(201);
        $shift = Shift::first();

        // Step 3: Create a Resource for the shift
        $resource = Resource::factory()->create([
            'shift_id' => $shift->id,
        ]);

        // Step 4: Create an Employee
        $employee = User::factory()->create(['role' => UserRoleEnum::Employee]);

        // Step 5: Employee Requests to Join the Shift
        $requestData = [
            'employee_id' => $employee->id,
            'shift_id' => $shift->id,
            'resource_id' => $resource->id
        ];

        $response = $this->actingAs($employee)->postJson("/api/shifts/{$shift->id}/request", $requestData);
        $response->assertStatus(201);
        $shiftRequest = ShiftRequest::first();
        $this->assertEquals(RequestStatusEnum::Pending, $shiftRequest->status);


        // Step 6: Manager Approves the Request
        $approveResponse = $this->actingAs($manager)->putJson("/api/shifts/approve/{$shiftRequest->id}");
        $approveResponse->assertStatus(200);

        // Assert that the status is updated to Approved
        $this->assertEquals(RequestStatusEnum::Approved, $shiftRequest->fresh()->status);
    }
}
