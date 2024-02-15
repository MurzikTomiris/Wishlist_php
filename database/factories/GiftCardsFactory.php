<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\Randomizer;


class GiftCardsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => Randomizer::generateRandomString(50),
            'wishlist_id' => fake()->numberBetween(0, 10),
            'link' => Randomizer::generateRandomString(50),
        ];
    }
}
