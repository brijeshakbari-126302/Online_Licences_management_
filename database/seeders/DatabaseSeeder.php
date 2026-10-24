<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\License;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Seed Demo Admin User
        User::firstOrCreate(
            ['email' => 'admin@licensehub.pro'],
            [
                'name' => 'Demo Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // 1. Create Vendors
        $jetbrains = Vendor::create([
            'name' => 'JetBrains',
            'website' => 'https://www.jetbrains.com',
            'contact_name' => 'Elena Rostova',
            'contact_email' => 'sales@jetbrains.com',
            'contact_phone' => '+420 241 722 501',
            'support_url' => 'https://jb.gg/support',
            'notes' => 'Primary IDE and developer tooling provider. Annual contract renewed in February.',
        ]);

        $microsoft = Vendor::create([
            'name' => 'Microsoft Corporation',
            'website' => 'https://www.microsoft.com',
            'contact_name' => 'David Vance',
            'contact_email' => 'ms-enterprise@microsoft.com',
            'contact_phone' => '+1 (800) 642-7676',
            'support_url' => 'https://support.microsoft.com',
            'notes' => 'Corporate Enterprise Agreement tier 2. Includes Office 365, Teams, and Azure credits.',
        ]);

        $adobe = Vendor::create([
            'name' => 'Adobe Inc.',
            'website' => 'https://www.adobe.com',
            'contact_name' => 'Sarah Jenkins',
            'contact_email' => 'sjenkins@adobe.com',
            'contact_phone' => '+1 (408) 536-6000',
            'support_url' => 'https://helpx.adobe.com',
            'notes' => 'Creative Cloud Suite dedicated account manager. Renewals handled quarterly.',
        ]);

        $figma = Vendor::create([
            'name' => 'Figma, Inc.',
            'website' => 'https://www.figma.com',
            'contact_name' => 'Marcus Chen',
            'contact_email' => 'sales-team@figma.com',
            'contact_phone' => '+1 (415) 890-3446',
            'support_url' => 'https://help.figma.com',
            'notes' => 'Product design system and prototyping licenses.',
        ]);

        $github = Vendor::create([
            'name' => 'GitHub Inc.',
            'website' => 'https://github.com',
            'contact_name' => 'Rachel Miller',
            'contact_email' => 'enterprise-success@github.com',
            'contact_phone' => '+1 (877) 448-4820',
            'support_url' => 'https://support.github.com',
            'notes' => 'GitHub Enterprise Cloud with GitHub Copilot Business add-ons.',
        ]);

        $slack = Vendor::create([
            'name' => 'Slack Technologies (Salesforce)',
            'website' => 'https://slack.com',
            'contact_name' => 'Alex Thorne',
            'contact_email' => 'licensing@slack.com',
            'contact_phone' => '+1 (415) 555-0199',
            'support_url' => 'https://slack.com/help',
            'notes' => 'Internal communication and automation platform.',
        ]);

        // 2. Create Employees
        $employees = [
            ['employee_id' => 'EMP-1001', 'name' => 'Alexander Brooks', 'email' => 'a.brooks@company.com', 'department' => 'Engineering', 'job_title' => 'Principal Software Architect', 'phone' => '+1 (555) 234-5678', 'status' => 'active'],
            ['employee_id' => 'EMP-1002', 'name' => 'Sophia Martinez', 'email' => 's.martinez@company.com', 'department' => 'Product & Design', 'job_title' => 'Lead Product Designer', 'phone' => '+1 (555) 345-6789', 'status' => 'active'],
            ['employee_id' => 'EMP-1003', 'name' => 'Lucas Tanaka', 'email' => 'l.tanaka@company.com', 'department' => 'Engineering', 'job_title' => 'Senior Full Stack Engineer', 'phone' => '+1 (555) 456-7890', 'status' => 'active'],
            ['employee_id' => 'EMP-1004', 'name' => 'Emily Watson', 'email' => 'e.watson@company.com', 'department' => 'DevOps & IT', 'job_title' => 'Cloud Infrastructure Engineer', 'phone' => '+1 (555) 567-8901', 'status' => 'active'],
            ['employee_id' => 'EMP-1005', 'name' => 'Noah Patel', 'email' => 'n.patel@company.com', 'department' => 'Engineering', 'job_title' => 'Backend Laravel Specialist', 'phone' => '+1 (555) 678-9012', 'status' => 'active'],
            ['employee_id' => 'EMP-1006', 'name' => 'Olivia Kim', 'email' => 'o.kim@company.com', 'department' => 'Product & Design', 'job_title' => 'Senior UX Researcher', 'phone' => '+1 (555) 789-0123', 'status' => 'active'],
            ['employee_id' => 'EMP-1007', 'name' => 'Liam O\'Connor', 'email' => 'l.oconnor@company.com', 'department' => 'Marketing', 'job_title' => 'Creative Director', 'phone' => '+1 (555) 890-1234', 'status' => 'active'],
            ['employee_id' => 'EMP-1008', 'name' => 'Ava Robinson', 'email' => 'a.robinson@company.com', 'department' => 'DevOps & IT', 'job_title' => 'IT Systems Administrator', 'phone' => '+1 (555) 901-2345', 'status' => 'active'],
            ['employee_id' => 'EMP-1009', 'name' => 'Ethan Clark', 'email' => 'e.clark@company.com', 'department' => 'Engineering', 'job_title' => 'Frontend UI Engineer', 'phone' => '+1 (555) 012-3456', 'status' => 'active'],
            ['employee_id' => 'EMP-1010', 'name' => 'Isabella Davis', 'email' => 'i.davis@company.com', 'department' => 'Finance', 'job_title' => 'Financial Analyst', 'phone' => '+1 (555) 123-4567', 'status' => 'active'],
        ];

        $employeeModels = [];
        foreach ($employees as $data) {
            $employeeModels[] = Employee::create($data);
        }

        // 3. Create Licenses
        $licJetbrains = License::create([
            'vendor_id' => $jetbrains->id,
            'software_name' => 'JetBrains All Products Pack',
            'license_key' => 'JB-COMM-2026-X89T-91KA',
            'license_type' => 'Subscription',
            'category' => 'Development',
            'total_seats' => 15,
            'cost_per_seat' => 289.00,
            'currency' => 'USD',
            'billing_cycle' => 'annually',
            'purchase_date' => now()->subMonths(3)->toDateString(),
            'expiration_date' => now()->addMonths(9)->toDateString(),
            'status' => 'active',
            'notes' => 'Commercial annual subscription for full development stack (PhpStorm, IntelliJ, WebStorm).',
        ]);

        $licM365 = License::create([
            'vendor_id' => $microsoft->id,
            'software_name' => 'Microsoft 365 Enterprise E5',
            'license_key' => 'MS-E5-ENTERPRISE-88219-KLM',
            'license_type' => 'Enterprise',
            'category' => 'Productivity',
            'total_seats' => 50,
            'cost_per_seat' => 57.00,
            'currency' => 'USD',
            'billing_cycle' => 'monthly',
            'purchase_date' => now()->subMonths(6)->toDateString(),
            'expiration_date' => now()->addMonths(6)->toDateString(),
            'status' => 'active',
            'notes' => 'Full enterprise productivity suite with enhanced cybersecurity & compliance features.',
        ]);

        $licAdobe = License::create([
            'vendor_id' => $adobe->id,
            'software_name' => 'Adobe Creative Cloud All Apps',
            'license_key' => 'ADOBE-CC-VIP-489201-992',
            'license_type' => 'Per Seat',
            'category' => 'Design',
            'total_seats' => 6,
            'cost_per_seat' => 84.99,
            'currency' => 'USD',
            'billing_cycle' => 'monthly',
            'purchase_date' => now()->subMonths(11)->toDateString(),
            'expiration_date' => now()->addDays(12)->toDateString(), // Expiring soon!
            'status' => 'expiring_soon',
            'notes' => 'Allocated strictly for UI/UX Design and Creative Marketing leads. Pending renewal approval.',
        ]);

        $licFigma = License::create([
            'vendor_id' => $figma->id,
            'software_name' => 'Figma Enterprise Organization',
            'license_key' => 'FIGMA-ENT-ORGLIC-77401',
            'license_type' => 'Subscription',
            'category' => 'Design',
            'total_seats' => 10,
            'cost_per_seat' => 75.00,
            'currency' => 'USD',
            'billing_cycle' => 'annually',
            'purchase_date' => now()->subMonths(4)->toDateString(),
            'expiration_date' => now()->addMonths(8)->toDateString(),
            'status' => 'active',
            'notes' => 'Includes FigJam and Design System management permissions.',
        ]);

        $licGithub = License::create([
            'vendor_id' => $github->id,
            'software_name' => 'GitHub Enterprise Cloud + Copilot',
            'license_key' => 'GH-ENT-COPILOT-9941-AZ',
            'license_type' => 'Per Seat',
            'category' => 'Development',
            'total_seats' => 20,
            'cost_per_seat' => 39.00,
            'currency' => 'USD',
            'billing_cycle' => 'monthly',
            'purchase_date' => now()->subMonths(5)->toDateString(),
            'expiration_date' => now()->addMonths(7)->toDateString(),
            'status' => 'active',
            'notes' => 'Includes automated security code scanning and Copilot Business AI assistant.',
        ]);

        $licSlack = License::create([
            'vendor_id' => $slack->id,
            'software_name' => 'Slack Business+ Plan',
            'license_key' => 'SLACK-CORP-WP-33291-TX',
            'license_type' => 'Enterprise',
            'category' => 'Productivity',
            'total_seats' => 45,
            'cost_per_seat' => 12.50,
            'currency' => 'USD',
            'billing_cycle' => 'annually',
            'purchase_date' => now()->subYear()->toDateString(),
            'expiration_date' => now()->subDays(5)->toDateString(), // Expired!
            'status' => 'expired',
            'notes' => 'Expired grace period license - renewal invoice is in finance review.',
        ]);

        // 4. Create Assignments
        // JetBrains assignments
        Assignment::create([
            'license_id' => $licJetbrains->id,
            'employee_id' => $employeeModels[0]->id, // Alexander Brooks
            'assigned_date' => now()->subMonths(3)->toDateString(),
            'status' => 'active',
            'device_info' => 'MacBook Pro 16" (M3 Max, IT-092)',
            'notes' => 'Primary IDE for architectural development.',
        ]);

        Assignment::create([
            'license_id' => $licJetbrains->id,
            'employee_id' => $employeeModels[2]->id, // Lucas Tanaka
            'assigned_date' => now()->subMonths(2)->toDateString(),
            'status' => 'active',
            'device_info' => 'ThinkPad P1 Gen 6 (IT-114)',
            'notes' => 'PhpStorm & WebStorm activation.',
        ]);

        Assignment::create([
            'license_id' => $licJetbrains->id,
            'employee_id' => $employeeModels[4]->id, // Noah Patel
            'assigned_date' => now()->subMonths(1)->toDateString(),
            'status' => 'active',
            'device_info' => 'Mac Studio M2 (Desk #14)',
            'notes' => 'Backend development station.',
        ]);

        // Adobe assignments
        Assignment::create([
            'license_id' => $licAdobe->id,
            'employee_id' => $employeeModels[1]->id, // Sophia Martinez
            'assigned_date' => now()->subMonths(8)->toDateString(),
            'status' => 'active',
            'device_info' => 'MacBook Pro 14" M3 Pro',
            'notes' => 'Photoshop, Illustrator, AfterEffects.',
        ]);

        Assignment::create([
            'license_id' => $licAdobe->id,
            'employee_id' => $employeeModels[6]->id, // Liam O'Connor
            'assigned_date' => now()->subMonths(4)->toDateString(),
            'status' => 'active',
            'device_info' => 'iMac 24" M3',
            'notes' => 'Marketing video and banner asset creation.',
        ]);

        // Figma assignments
        Assignment::create([
            'license_id' => $licFigma->id,
            'employee_id' => $employeeModels[1]->id, // Sophia Martinez
            'assigned_date' => now()->subMonths(4)->toDateString(),
            'status' => 'active',
            'device_info' => 'MacBook Pro 14" M3 Pro',
            'notes' => 'Design System admin editor seat.',
        ]);

        Assignment::create([
            'license_id' => $licFigma->id,
            'employee_id' => $employeeModels[5]->id, // Olivia Kim
            'assigned_date' => now()->subMonths(3)->toDateString(),
            'status' => 'active',
            'device_info' => 'MacBook Air M2',
            'notes' => 'UX prototyping & wireframing.',
        ]);

        // GitHub assignments
        Assignment::create([
            'license_id' => $licGithub->id,
            'employee_id' => $employeeModels[0]->id,
            'assigned_date' => now()->subMonths(5)->toDateString(),
            'status' => 'active',
            'device_info' => 'MacBook Pro 16" (M3 Max, IT-092)',
            'notes' => 'Copilot code generation.',
        ]);

        Assignment::create([
            'license_id' => $licGithub->id,
            'employee_id' => $employeeModels[2]->id,
            'assigned_date' => now()->subMonths(5)->toDateString(),
            'status' => 'active',
            'device_info' => 'ThinkPad P1 Gen 6 (IT-114)',
            'notes' => 'Repository write and review access.',
        ]);

        Assignment::create([
            'license_id' => $licGithub->id,
            'employee_id' => $employeeModels[4]->id,
            'assigned_date' => now()->subMonths(4)->toDateString(),
            'status' => 'active',
            'device_info' => 'Mac Studio M2',
            'notes' => 'Copilot and CI/CD pipelines.',
        ]);

        Assignment::create([
            'license_id' => $licGithub->id,
            'employee_id' => $employeeModels[8]->id, // Ethan Clark
            'assigned_date' => now()->subMonths(2)->toDateString(),
            'status' => 'active',
            'device_info' => 'MacBook Pro 14" M2 Pro',
            'notes' => 'Frontend repo access & Copilot.',
        ]);

        // Revoked assignment example
        Assignment::create([
            'license_id' => $licAdobe->id,
            'employee_id' => $employeeModels[8]->id, // Ethan Clark
            'assigned_date' => now()->subMonths(9)->toDateString(),
            'revoked_date' => now()->subMonths(2)->toDateString(),
            'status' => 'revoked',
            'device_info' => 'Dell Latitude 7420 (Returned)',
            'notes' => 'Transferred to Figma exclusively.',
        ]);
    }
}
