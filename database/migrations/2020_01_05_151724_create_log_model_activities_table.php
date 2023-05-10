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
        Schema::create('log_model_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id')->unsigned()->index();
            $table->string('subject_type', 150)->index();
            $table->string('name', 191);
            $table->text('before')->nullable();
            $table->text('after')->nullable();
            $table->integer('user_id')->unsigned()->index();
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
        Schema::drop('log_model_activities');
    }
};
