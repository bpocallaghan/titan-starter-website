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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('summary')->nullable();
            $table->text('content');
            $table->string('slug');
            $table->timestamp('active_from')->nullable(); // aka posted_at (default now)
            $table->timestamp('active_to')->nullable();
            $table->string('action_name')->nullable(); // aka posted_at (default now)
            $table->string('action_url')->nullable();
            $table->integer('category_id');
            $table->bigInteger('total_views')->unsigned()->default(0);
            $table->bigInteger('facebook_shares')->unsigned()->default(0);
            $table->bigInteger('twitter_shares')->unsigned()->default(0);
            $table->bigInteger('pinterest_shares')->unsigned()->default(0);
            $table->bigInteger('googleplus_shares')->unsigned()->default(0);
            $table->boolean('allow_comments')->nullable();
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
        Schema::dropIfExists('articles');
    }
};
