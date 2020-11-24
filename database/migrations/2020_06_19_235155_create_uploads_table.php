<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('accept')->nullable();
            $table->string('flight_number');
            $table->dateTime('std');
            $table->string('from', 3);
            $table->string('to', 3)->nullable();
            $table->string('rego', 6)->nullable();
            $table->string('send')->nullable();
            $table->string('description');
            $table->string('assurance');
            $table->string('packing');
            $table->string('message_approval')->nullable();
            $table->string('volume_unit')->nullable();
            $table->float('volume', 5, 2);
            $table->float('pieces', 10, 2);
            $table->float('weight', 10, 2);
            $table->integer('origins_id')
                ->foreign('origins_id')
                ->references('id')
                ->on('origins');
            $table->integer('created_by')
                ->foreign('users_id')
                ->references('id')
                ->on('users');
            $table->integer('approved_by')
                ->foreign('users_id')
                ->references('id')
                ->on('users')
                ->nullable();
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
        Schema::dropIfExists('uploads');
    }
}
