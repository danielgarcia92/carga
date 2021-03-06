<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rol');
            $table->integer('areas_id')
                ->foreign('areas_id')
                ->references('id')
                ->on('areas');
            $table->integer('airports_id')
                ->foreign('airports_id')
                ->references('id')
                ->on('airports')
                ->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
