<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {

        $roles = Role::all();

        User::factory(20)->create()->each(function ($user) use ($roles) {
            if ($roles->isNotEmpty()) {
                $role = $roles->random();

                $user->assignRole($role->name);

                $user->role_id = $role->id;
                $user->role = $role->name;
                $user->save();
            }
        });
    }
}
