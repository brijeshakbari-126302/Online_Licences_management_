<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => 'EMP-'.fake()->unique()->numberBetween(1001, 9999),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'department' => fake()->randomElement(['Engineering', 'Product & Design', 'DevOps & IT', 'Marketing', 'Sales', 'Finance', 'Human Resources']),
            'job_title' => fake()->jobTitle(),
            'phone' => fake()->phoneNumber(),
            'status' => 'active',
        ];
    }
}
