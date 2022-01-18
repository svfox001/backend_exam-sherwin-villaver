<?php

use Illuminate\Database\Seeder;
use App\User\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Sherwin";
        $user->email = "test@gmail.com";
        $user->password = bcrypt("secret");
        $user->save();
    }
}
