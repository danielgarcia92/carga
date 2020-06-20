<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /** @return void */
    public function run()
    {
        $this->truncateTables([
            'origins'
        	, 'uploads'
            , 'users'
        ]);
        $this->call(OriginSeeder::class);
        $this->call(UploadSeeder::class);
        $this->call(UserSeeder::class);
    }

    public function truncateTables(array $tables)
    {
    	//DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    	foreach ($tables as $table) {
    		DB::table($table)->truncate();
    	}
    	//DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
