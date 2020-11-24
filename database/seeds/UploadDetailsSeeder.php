<?php

use App\UploadDetails;
use Illuminate\Database\Seeder;

class UploadDetailsSeeder extends Seeder
{
    /** @return void */
    public function run()
    {
        factory(UploadDetails::class)->create();
    }
}
