<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'akinfergie@gmail.com')->first();

        if(!$user){
            User::create([
                'name' => 'Akinfergie',
                'email' => 'akinfergie@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('password')

            ]);
        }
    }
}
