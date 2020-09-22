<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $newUser = User::create([
            'name' => 'Testing User',
            'email' => 'test@fake.com',
            'password' => Hash::make('testing'),
            'password_needs_reset' => 0
        ]);

        $adminRole = Role::create([
            'name' => 'admin'
        ]);

        $newUser->roles()->sync($adminRole->id);
    }
}
