<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\Randomizer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wishlists>
 */
class WishlistsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => Randomizer::generateRandomString(50),
            'listLink' => Randomizer::generateRandomString(50),
            'AccountId' => fake()->numberBetween(0, 10),
            'IsActive' => true,
        ];
    }
}
