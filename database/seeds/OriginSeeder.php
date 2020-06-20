<?php

use App\Origin;
use Illuminate\Database\Seeder;

class OriginSeeder extends Seeder
{
    /** @return void */
    public function run()
    {
    	factory(Origin::class, 2)->create();
    }
}
