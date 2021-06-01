<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = "admin";
        $role->description = "administrator";
        $role->save();
        $role_id = $role->id;
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@humane.uz";
        $user->password = bcrypt("sdf23432DF32");

        $user->save();
        $user->roles()->attach($role_id);
        $user->save();
    }
}
