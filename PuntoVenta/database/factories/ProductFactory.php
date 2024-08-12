<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
        return [
            'product_name' => $this->faker->word(),
            'category_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'supplier_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'product_garage' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'short_description' => $this->faker->sentence(),
            'long_description' => $this->faker->paragraph(),
            'buying_price' => $this->faker->numberBetween(10, 1000),
            'selling_price' => $this->faker->numberBetween(15, 1500),
            'buying_date' => $this->faker->date(),
            'expire_date' => $this->faker->dateBetween('now', '+2 years'),
        ];
    }
}
