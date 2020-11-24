<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_details', function (Blueprint $table) {
            $table->id();
            $table->string('guide_number');
            $table->float('pieces', 10, 2);
            $table->float('weight', 10, 2);
            $table->float('volume', 5, 2);
            $table->string('nature_goods');
            $table->string('route_item');
            $table->integer('accept')->nullable();
            $table->integer('uploads_id')
                ->foreign('uploads_id')
                ->references('id')
                ->on('uploads');
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
        Schema::dropIfExists('upload_details');
    }
}
