<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Sanctum\HasApiTokens;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name'              => $this->faker->words(2, true),
            'sku' => $this->faker
                ->optional(0.7, null)   // 70% chance to run bothify(), else null
                ->bothify('P-###?'),
            'mpn'          => $this->faker->randomElement(['Shelf A', 'Room 2', 'Warehouse X']),
            'quantity'  => $this->faker->numberBetween(0, 500),
            'is_active'         => $this->faker->boolean(85),
        ];
    }
}
