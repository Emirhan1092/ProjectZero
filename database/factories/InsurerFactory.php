<?php

namespace Database\Factories;

use App\Models\Insurer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Insurer>
 */
class InsurerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Insurer::class;
    public function definition(): array
    {
        return [

            'insurance_company' => fake()->company(),
            'address' => fake()->address(),

        ];
    }
}
