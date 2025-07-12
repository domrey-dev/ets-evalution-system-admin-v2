<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'staff_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'en_name' => $this->faker->name(),
            'kh_name' => 'ខ្មែរ ' . $this->faker->firstName(),
            'phone' => '0' . $this->faker->numberBetween(10_000_000, 99_999_999),
            'work_contract' => $this->faker->randomElement(['Permanent', 'Project-based', 'Internship', 'Subcontract']),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            // 'roles' => $this->faker->randomElement(['admin', 'GM', 'Manager', 'HR', 'Site Manager', 'Site Supervisor', 'Site Team Leader', 'Staff']),
            'start_of_work' => $this->faker->date(),
            'end_of_work' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => time(),
            'updated_at' => time(),

        ];
    }
}
