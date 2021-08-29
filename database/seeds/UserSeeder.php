<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'BoyMilo',
            'name' => 'Boy Milo',
            'avatar' => null,
            'password' => Hash::make('password')
        ]);
        $user->assignRole('admin');
        for($i = 0; $i < 10; $i++)
        {
            $user1 = User::create([
                'username' => 'BoyMilo'.$i,
                'name' => 'Boy Milo'.$i,
                'avatar' => null,
                'password' => Hash::make('password')
            ]);
            $user1->assignRole('user');
        }
    }
}
