<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Product::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->unique()->sentence($nbWords = 3, $variableNbWords = true),
      'price' => $this->faker->randomFloat(2, 1, 9999),
      'stock' => $this->faker->numberBetween(1, 50),
      'category_id' => $this->faker->numberBetween(1, 10),
      'image' => $this->faker->imageUrl($width = 640, $height = 480)
    ];
  }
}
