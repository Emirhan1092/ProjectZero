<?php

namespace Database\Seeders;


use App\Models\Accident;
use App\Models\CarOwner;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles= Vehicle::all();

        foreach ($vehicles as $vehicle) {
            $owner  = User::find($vehicle->user_id);
            $accident = Accident::where('vehicle_id', $vehicle->id)->first();
            if($owner) {
            CarOwner::factory()->create([
                'user_id' => $vehicle->user_id,
                'vehicle_id' => $vehicle->id,
                'accident_id' => $accident ? $accident->id : null,
                'name' => $owner->name,
                'phone_number' => $owner->phone_number,
                'image' => $owner->image,
                'email' => $owner->email,

               ] );

        }}


    }
}
