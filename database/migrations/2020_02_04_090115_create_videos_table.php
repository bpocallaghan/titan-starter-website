<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_cover')->default(false);
            $table->string('name');
            $table->text('content')->nullable();
            $table->string('link');
            $table->string('image')->nullable();
            $table->boolean('is_youtube')->default(true);
            $table->integer('videoable_id');
            $table->string('videoable_type');
            $table->integer('list_order')->default(999);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
