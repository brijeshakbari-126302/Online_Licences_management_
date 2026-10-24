<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\License;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendingPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_reports_page_renders_successfully(): void
    {
        $vendor = Vendor::factory()->create();
        License::factory()->create(['vendor_id' => $vendor->id]);

        $response = $this->get(route('reports.index'));

        $response->assertStatus(200);
        $response->assertSee('Reports & License Analytics', false);
        $response->assertSee('Annual Software Investment');
        $response->assertSee('Global Utilization Rate');
    }

    public function test_reports_csv_export_works(): void
    {
        $vendor = Vendor::factory()->create(['name' => 'Acme Tools Corp']);
        License::factory()->create([
            'vendor_id' => $vendor->id,
            'software_name' => 'Acme Suite Pro',
        ]);

        $response = $this->get(route('reports.export', 'licenses'));

        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', (string) $response->headers->get('content-type'));
    }

    public function test_renewals_page_renders_successfully(): void
    {
        $vendor = Vendor::factory()->create();
        License::factory()->create([
            'vendor_id' => $vendor->id,
            'software_name' => 'Figma Enterprise',
            'expiration_date' => now()->addDays(15),
            'status' => 'expiring_soon',
        ]);

        $response = $this->get(route('renewals.index'));

        $response->assertStatus(200);
        $response->assertSee('Renewals & Contract Expirations', false);
        $response->assertSee('Figma Enterprise');
    }

    public function test_can_extend_license_renewal(): void
    {
        $vendor = Vendor::factory()->create();
        $license = License::factory()->create([
            'vendor_id' => $vendor->id,
            'software_name' => 'Slack Business+',
            'expiration_date' => now()->toDateString(),
            'status' => 'expired',
        ]);

        $response = $this->post(route('renewals.extend', $license), [
            'extension_type' => '1_year',
            'notes' => 'Renewed per annual PO-998822',
        ]);

        $response->assertRedirect();
        $license->refresh();

        $this->assertEquals('active', $license->status);
        $this->assertTrue($license->expiration_date->isFuture());
    }

    public function test_activity_log_page_renders_successfully(): void
    {
        $vendor = Vendor::factory()->create();
        $license = License::factory()->create(['vendor_id' => $vendor->id]);
        $employee = Employee::factory()->create();

        Assignment::create([
            'license_id' => $license->id,
            'employee_id' => $employee->id,
            'assigned_date' => now()->toDateString(),
            'device_info' => 'ThinkPad X1',
            'status' => 'active',
        ]);

        $response = $this->get(route('activity.index'));

        $response->assertStatus(200);
        $response->assertSee('Audit Trail & System Activity', false);
        $response->assertSee($employee->name);
    }

    public function test_settings_page_renders_successfully(): void
    {
        $response = $this->get(route('settings.index'));

        $response->assertStatus(200);
        $response->assertSee('System Settings & Preferences', false);
        $response->assertSee('Organizational Preferences');
        $response->assertSee('System Runtime Diagnostics');
    }

    public function test_can_update_settings(): void
    {
        $payload = [
            'company_name' => 'Acme Global Technologies',
            'admin_email' => 'admin@acmeglobal.com',
            'default_currency' => 'USD',
            'alert_lead_days' => 30,
        ];

        $response = $this->post(route('settings.update'), $payload);

        $response->assertRedirect(route('settings.index'));
        $response->assertSessionHas('success');
        $this->assertEquals('Acme Global Technologies', session('settings.company_name'));
    }
}
