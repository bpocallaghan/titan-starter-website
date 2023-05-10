<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_cover')->default(false);
            $table->string('name')->nullable();
            $table->text('content')->nullable();
            $table->string('link')->nullable();
            $table->string('filename')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_youtube')->default(false);
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
};
