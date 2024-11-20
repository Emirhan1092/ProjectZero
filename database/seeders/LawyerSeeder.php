<?php

namespace Database\Seeders;

use App\Models\Lawyer;
use App\Models\User;
use Database\Factories\LawyerFactory;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $lawyers = User::role('lawyer')->get();

        foreach ($lawyers as $lawyer) {
            Lawyer::factory()->create([
                 'user_id' => $lawyer->id,
                'name' => $lawyer->name,
                'email' => $lawyer->email,
                'phone_number' => $lawyer->phone_number,
                'image' => $lawyer->image,


            ]);
        }
    }
}
