<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\License;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LicenseManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_renders_successfully(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Executive License Dashboard');
    }

    public function test_can_create_and_view_vendor(): void
    {
        $vendorData = [
            'name' => 'JetBrains s.r.o.',
            'website' => 'https://www.jetbrains.com',
            'contact_name' => 'Sales Team',
            'contact_email' => 'sales@jetbrains.com',
            'contact_phone' => '+420 123 456 789',
            'support_url' => 'https://jb.gg/support',
            'notes' => 'Primary IDE vendor.',
        ];

        $response = $this->post(route('vendors.store'), $vendorData);

        $response->assertRedirect();
        $this->assertDatabaseHas('vendors', ['name' => 'JetBrains s.r.o.']);

        $vendor = Vendor::where('name', 'JetBrains s.r.o.')->first();
        $this->get(route('vendors.show', $vendor))->assertStatus(200)->assertSee('JetBrains s.r.o.');
    }

    public function test_can_create_and_view_employee(): void
    {
        $employeeData = [
            'employee_id' => 'EMP-5001',
            'name' => 'Jane Developer',
            'email' => 'jane.dev@company.com',
            'department' => 'Engineering',
            'job_title' => 'Software Engineer',
            'phone' => '+1 555 999 8888',
            'status' => 'active',
        ];

        $response = $this->post(route('employees.store'), $employeeData);

        $response->assertRedirect();
        $this->assertDatabaseHas('employees', ['employee_id' => 'EMP-5001']);

        $employee = Employee::where('employee_id', 'EMP-5001')->first();
        $this->get(route('employees.show', $employee))->assertStatus(200)->assertSee('Jane Developer');
    }

    public function test_can_create_and_view_license(): void
    {
        $vendor = Vendor::factory()->create();

        $licenseData = [
            'vendor_id' => $vendor->id,
            'software_name' => 'PhpStorm',
            'license_key' => 'PS-1234-ABCD-5678',
            'license_type' => 'Subscription',
            'category' => 'Development',
            'total_seats' => 10,
            'cost_per_seat' => 199.00,
            'currency' => 'USD',
            'billing_cycle' => 'annually',
            'purchase_date' => now()->toDateString(),
            'expiration_date' => now()->addYear()->toDateString(),
            'status' => 'active',
            'notes' => 'Team developer licenses',
        ];

        $response = $this->post(route('licenses.store'), $licenseData);

        $response->assertRedirect();
        $this->assertDatabaseHas('licenses', ['software_name' => 'PhpStorm']);

        $license = License::where('software_name', 'PhpStorm')->first();
        $this->get(route('licenses.show', $license))->assertStatus(200)->assertSee('PhpStorm');
    }

    public function test_can_assign_seat_to_employee(): void
    {
        $vendor = Vendor::factory()->create();
        $license = License::factory()->create(['vendor_id' => $vendor->id, 'total_seats' => 5]);
        $employee = Employee::factory()->create();

        $assignmentData = [
            'license_id' => $license->id,
            'employee_id' => $employee->id,
            'assigned_date' => now()->toDateString(),
            'device_info' => 'MacBook Pro 16',
            'notes' => 'Assigned for active development',
        ];

        $response = $this->post(route('assignments.store'), $assignmentData);

        $response->assertRedirect();
        $this->assertDatabaseHas('assignments', [
            'license_id' => $license->id,
            'employee_id' => $employee->id,
            'status' => 'active',
        ]);
    }
}
