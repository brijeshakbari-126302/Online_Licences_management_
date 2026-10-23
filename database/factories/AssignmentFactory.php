<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\License;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'license_id' => License::factory(),
            'employee_id' => Employee::factory(),
            'assigned_date' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'revoked_date' => null,
            'status' => 'active',
            'device_info' => fake()->randomElement(['MacBook Pro 16" M3 Max', 'ThinkPad X1 Carbon Gen 11', 'Dell XPS 15 9530', 'Mac Studio M2 Ultra', 'HP Elite Dragonfly']),
            'notes' => fake()->sentence(),
        ];
    }
}
