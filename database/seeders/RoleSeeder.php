<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('model_has_roles')->truncate();

        Role::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'repairman', 'guard_name' => 'web']);
        Role::create(['name' => 'expertise', 'guard_name' => 'web']);
        Role::create(['name' => 'lawyer', 'guard_name' => 'web']);
        Role::create(['name' => 'insurer', 'guard_name' => 'web']);
        Role::create(['name' => 'car_owner', 'guard_name' => 'web']);
    }
}
