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
            $table->string('legcd')->nullable();
            $table->dateTime('std');
            $table->string('from', 3);
            $table->string('to', 3);
            $table->string('rego', 6)->nullable();
            $table->string('guide_number', 14)->nullable();
            $table->string('send');
            $table->string('description');
            $table->string('assurance');
            $table->string('packing');
            $table->string('message_approval')->nullable();
            $table->string('volume_unit')->nullable();
            $table->string('id_mensaje_rcv')->nullable();
            $table->string('route_item')->nullable();
            $table->string('extra1')->nullable();
            $table->string('extra2')->nullable();
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
