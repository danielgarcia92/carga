<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->integer('areas_id')
                ->foreign('areas_id')
                ->references('id')
                ->on('areas');
            $table->integer('airports_id')
                ->foreign('airports_id')
                ->references('id')
                ->on('airports');
            $table->tinyInteger('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
