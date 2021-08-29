<?php

use Illuminate\Database\Seeder;
// use UsersSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PerrmissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleHasPermission::class);
    }
}
