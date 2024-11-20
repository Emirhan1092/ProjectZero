<?php

namespace Database\Factories;

use App\Models\RepairMan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RepairMan>
 */
class RepairManFactory extends Factory
{
    protected $model = RepairMan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'address' =>  fake()->address(),
            'shop_name' => fake()->name(),
            'number_of_services' => rand(1, 10),
            'star' => rand(1, 5),
            'rating' => rand(1, 5),
            'start_date' =>fake()->date(),
        ];
    }
}
