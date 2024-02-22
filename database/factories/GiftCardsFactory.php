<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\Randomizer;
use App\Models\Wishlists;


class GiftCardsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->text(50),
            'wishlist_id' => Wishlists::all()->random()->id,
            'link' => fake()->url(),
        ];
    }
}
