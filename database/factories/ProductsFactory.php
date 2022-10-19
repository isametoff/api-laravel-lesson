<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->company,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(1500, 6000),
            'rest' => $this->faker->numberBetween(1, 6),
            'is_published' => 1,
        ];
    }
}
