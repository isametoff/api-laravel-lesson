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
            'first_name' => $this->faker->firstName,
            'middle_name' => null,
            'last_name' => $this->faker->lastName,
            'sex' => $this->faker->randomElement(['M', 'F', 'N']),
            'country' => 'us',
            'adress' => $this->faker->address(),
            'adress2' => $this->faker->address(),
            'work_phone' => null,
            'home_phone' => '4043789865',
            'marital_status' => $this->faker->randomElement(['Single', 'Married']),
            'email' => $this->faker->email(),
            'dob_year' => '2012',
            // 'dob_year' => '2012/01/31',
            'state' => $this->faker->state,
            'sity' => $this->faker->city,
            'dl' => $this->faker->randomElement([null, 12121212]),
            // 'dl' => $this->faker->numberBetween(0, 60000000),
            'zip' => $this->faker->numberBetween(10000, 90000),
            'price' => $this->faker->numberBetween(1, 3),
        ];
    }
}
