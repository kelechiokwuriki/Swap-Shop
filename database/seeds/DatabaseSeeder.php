<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $firstUser = User::first();

        $adminRole = Role::create([
            'name' => 'admin'
        ]);

        $firstUser->roles()->sync($adminRole->id);
    }
}
