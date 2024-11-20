<?php

namespace Database\Factories;

use App\Models\Expertise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarModel>
 */
class ExpertiseFactory extends Factory
{
    protected $model = Expertise::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
               'company_name' => fake()->company(),
               'expertise_area' => fake()->word(),
               'number_of_services' => fake()->numberBetween(1,10),
                'star' => rand(1,5),
                'rating' => rand(1,5),
                 'start_date' => fake()->date(),
         ];
    }
}
