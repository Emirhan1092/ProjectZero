<?php

namespace Database\Factories;

use App\Models\Accident;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accident>
 */
class AccidentFactory extends Factory
{
    protected $model = Accident::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition():array
    {
        return [
            'accident_type' => fake()->word(),
            'accident_date' => fake()->dateTime(),
            'description' => fake()->paragraph(),
            'accident_status' => fake()->randomElement(['Açık', 'Ekspertizde', 'Sigorta İşlemleri', 'Kapandı']),

        ];
    }
}
