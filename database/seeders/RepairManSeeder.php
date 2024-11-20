<?php

namespace Database\Seeders;

use App\Models\RepairMan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairManSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role('repairman')->get();

        foreach ($users as $user)
        {
            RepairMan::factory()->create([
                'user_id' => $user->id,
                'name' => $user->name,
                'phone_number' => $user->phone_number,
                'image' => $user->image,
            ]);

        }
    }
}
