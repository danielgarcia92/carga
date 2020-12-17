<?php

use App\Upload;
use Illuminate\Database\Seeder;

class UploadSeeder extends Seeder
{
    /** @return void */
    public function run()
    {
    	factory(Upload::class )->create();
    }
}
