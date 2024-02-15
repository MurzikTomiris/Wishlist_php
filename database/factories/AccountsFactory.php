<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Randomizer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AccountsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'login' => fake()->name(),
            'password' => Randomizer::generateRandomString(10),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'token' => Randomizer::generateRandomString(50),
        ];
    }
}
