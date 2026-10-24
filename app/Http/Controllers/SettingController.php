<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\License;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display the settings and system preferences page.
     */
    public function index(): View
    {
        $dbStatus = 'Connected';
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $dbStatus = 'Error: '.$e->getMessage();
        }

        $systemInfo = [
            'app_version' => '2.4.0 (Enterprise)',
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'environment' => app()->environment(),
            'database_status' => $dbStatus,
            'database_driver' => config('database.default'),
            'total_licenses' => License::count(),
            'total_assignments' => Assignment::count(),
            'total_vendors' => Vendor::count(),
            'total_employees' => Employee::count(),
            'storage_writable' => is_writable(storage_path()),
        ];

        return view('settings.index', [
            'systemInfo' => $systemInfo,
        ]);
    }

    /**
     * Update application settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255'],
            'default_currency' => ['required', 'string', 'max:10'],
            'alert_lead_days' => ['required', 'integer', 'min:7', 'max:180'],
            'auto_revoke_on_leave' => ['nullable', 'boolean'],
        ]);

        session([
            'settings.company_name' => $validated['company_name'],
            'settings.admin_email' => $validated['admin_email'],
            'settings.default_currency' => $validated['default_currency'],
            'settings.alert_lead_days' => $validated['alert_lead_days'],
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'System preferences and organizational settings saved successfully.');
    }
}
