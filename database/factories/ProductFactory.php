<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraph(),
            'category_id' => \App\Models\Category::factory(),
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'old_price' => $this->faker->optional()->randomFloat(2, 10, 1000),
            'rating' => $this->faker->optional()->randomFloat(1, 0, 5),
            'rating_count' => $this->faker->optional()->numberBetween(0, 1000),
            'is_published' => $this->faker->boolean(),
        ];
    }
}
