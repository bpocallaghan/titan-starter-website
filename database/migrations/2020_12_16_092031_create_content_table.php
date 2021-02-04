<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            // $table->integer('section_id')->unsigned()->index();
            $table->string('heading')->nullable();
            $table->string('heading_element')->default('h2');
            $table->string('heading_class')->nullable();
            $table->text('content')->nullable();
            $table->string('media')->nullable();
            $table->string('media_align', 50)->default('left');
            $table->string('caption')->nullable();
            $table->string('action_name')->nullable();
            $table->string('action_url')->nullable();
            $table->integer('list_order')->default(99);
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
        Schema::dropIfExists('content');
    }
}
