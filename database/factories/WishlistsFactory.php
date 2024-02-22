<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\Randomizer;
use App\Models\Accounts;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wishlists>
 */
class WishlistsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => Randomizer::generateRandomString(50),
            'listLink' => Randomizer::generateRandomString(50),
            'AccountId' => Accounts::all()->random()->id,
            'IsActive' => true,
        ];
    }
}
