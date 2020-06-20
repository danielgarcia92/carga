<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /** @return void */
    public function run()
    {
    	factory(User::class)->create();
    }
}
