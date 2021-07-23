<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;

class ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'brand' => $this->faker->sentence($nbWords = 2),
            'category' => $this->faker->sentence($nbWords = 2),
            'price'=>$this->faker->randomElement($array = ['1.15','2.25','3.5']),
            'details'=>$this->faker->paragraph()
        ];
    }
}
