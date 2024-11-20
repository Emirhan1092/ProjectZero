<?php

namespace Database\Seeders;

use App\Models\Expertise;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpertiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role('Expertise')->get();

        foreach ($users as $user) {
            Expertise::factory()->create([
               'user_id' => $user->id,
               'name' => $user->name,
               'email' => $user->email,
               'phone_number' => $user->phone_number,

            ]);
        }

    }
}
