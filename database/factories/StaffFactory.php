<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'staff_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'en_name' => $this->faker->name(),
            'kh_name' => 'ខ្មែរ ' . $this->faker->firstName(),
            'phone_number' => '0' . $this->faker->numberBetween(10_000_000, 99_999_999),
            'work_contract' => $this->faker->randomElement(['Permanent', 'Project-based', 'Internship', 'Subcontract']),
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'role' => $this->faker->randomElement(['admin', 'GM', 'Manager', 'HR', 'Site Manager', 'Site Supervisor', 'Site Team Leader', 'Staff']),
            'hire_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
