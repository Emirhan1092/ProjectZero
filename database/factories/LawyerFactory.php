<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarModel>
 */
class LawyerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $profession = [
            'Trafik Hukuku',
            'Karayolu Taşıma Hukuku',
            'Motorlu Araçlar Hukuku',
            'Sigorta Hukuku (Taşıt Sigortaları)',
        ];


        return [
            'address' => fake()->address(),
            'specialization' => fake()->randomElement($profession),
            'license_number' => fake()->regexify('[A-Za-z0-9]+'),
            'license_expiry' => fake()->date(),


        ];
    }
}
