<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'brand' => fake()->word,
            'model' => fake()->word,
            'year' => fake()->year($max = 'now'),
            'color' => fake()->safeColorName(),
            'kilometers' => fake()->numberBetween(0, 200000),
            'vehicle_register_plate' => fake()->unique()->bothify('##???###'),
            'VIN' => fake()->unique()->numerify('1HGCM82633A#####'),
            'engine_number' => fake()->unique()->numerify('EN#####'),
            'fuel_type' => fake()->randomElement(['Gasoline', 'Diesel', 'Electric', 'Hybrid']),
        ];
    }
}
