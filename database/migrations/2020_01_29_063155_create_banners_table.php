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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('action_name')->nullable();
            $table->string('action_url')->nullable();
            $table->string('image');
            $table->timestamp('active_from')->nullable();
            $table->timestamp('active_to')->nullable();
            $table->boolean('is_website')->default(0); // if for a page or website
            $table->boolean('hide_name')->default(0); // to hide the banner name
            $table->integer('list_order')->default(1); // default first banner
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
        Schema::dropIfExists('banners');
    }
};
