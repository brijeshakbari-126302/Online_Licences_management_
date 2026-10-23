<?php

namespace Database\Factories;

use App\Models\License;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<License>
 */
class LicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id' => Vendor::factory(),
            'software_name' => fake()->randomElement([
                'JetBrains All Products Pack', 'IntelliJ IDEA Ultimate', 'PhpStorm Pro',
                'Microsoft 365 Enterprise E5', 'GitHub Enterprise Cloud', 'Adobe Creative Cloud All Apps',
                'Figma Enterprise', 'Slack Business+', 'AWS Cloud Support', 'Jira Service Management',
                'Datadog Pro', 'Tableau Desktop', 'Notion Team Plan', '1Password Teams', 'Postman Enterprise',
            ]),
            'license_key' => strtoupper(fake()->bothify('????-####-????-####-????')),
            'license_type' => fake()->randomElement(['Subscription', 'Perpetual', 'Per Seat', 'Enterprise']),
            'category' => fake()->randomElement(['Development', 'Design', 'Productivity', 'Security', 'DevOps', 'Data & Analytics']),
            'total_seats' => fake()->numberBetween(5, 50),
            'cost_per_seat' => fake()->randomFloat(2, 15, 250),
            'currency' => 'USD',
            'billing_cycle' => fake()->randomElement(['monthly', 'annually']),
            'purchase_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'expiration_date' => fake()->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'status' => 'active',
            'notes' => fake()->sentence(),
        ];
    }
}
