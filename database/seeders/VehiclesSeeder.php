<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\User;

class VehiclesSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('car_owner')->get();

        foreach ($users as $user) {
            Vehicle::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
