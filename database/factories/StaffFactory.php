<?php

namespace Database\Factories;

use App\Models\Position;
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
            'position_id' => Position::inRandomOrder()->first()->id ?? 1,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'en_name' => fake()->name(),
            'kh_name' => 'ខ្មែរ ' . fake()->firstName(),
            'phone' => '0' . fake()->numberBetween(10_000_000, 99_999_999),
            'work_contract' => fake()->randomElement(['Permanent', 'Project-based', 'Internship', 'Subcontract']),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'start_of_work' => fake()->date(),
            'end_of_work' => fake()->date(),
            'status' => fake()->randomElement(['active', 'inactive']),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
