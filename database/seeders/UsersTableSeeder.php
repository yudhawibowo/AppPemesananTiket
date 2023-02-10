<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user = new User;
        $user->name = "admin";
        $user->email = "admin@gmail.com";
        $user->location = "admin";
        $user->phone_number = "08232342344";
        $user->photo = "no_image.png";
        $user->role_id = "1";
        $user->password = Hash::make('12345');
        $user->save();
    }
}
