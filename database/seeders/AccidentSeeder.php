<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accident;
use App\Models\User;
use App\Models\Vehicle;

class AccidentSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 10) as $index) {
            $repairmen = User::role('repairman')->get();
            $carOwners = User::role('car_owner')->get();

            foreach ($carOwners as $carOwner) {
                $vehicle = Vehicle::where('user_id', $carOwner->id)->first(); // carOwner'a ait aracı bul

                if ($vehicle) {
                    $repairman = $repairmen->random();

                    Accident::factory()->create([
                        'vehicle_id' => $vehicle->id,
                        'user_id' => $carOwner->id,
                        'repairman_id' => $repairman->id,
                    ]);
                }
            }
        }
    }
}
