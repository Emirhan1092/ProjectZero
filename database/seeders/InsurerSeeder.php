<?php
namespace Database\Seeders;

use App\Models\Insurer;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class InsurerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Insurer::truncate();


        $insurer = User::role('insurer')->get();

        foreach ($insurer as $index => $randomInsurer) {
            Insurer::factory()->create([

                'user_id' => $randomInsurer->id,
                'insurer_name' => $randomInsurer->name,
                'image' => $randomInsurer->image,
                'email' => $randomInsurer->email,
                'phone_number' => $randomInsurer->phone_number,

            ]);
        }

    }
}
