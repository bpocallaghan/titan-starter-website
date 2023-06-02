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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slogan')->nullable();
            $table->text('description');
            $table->text('keywords')->nullable();
            $table->string('author');

            // contact
            $table->string('email')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('telephone')->nullable();
            $table->string('address')->nullable();
            $table->string('po_box')->nullable();

            $table->string('fax')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('directions')->nullable();

            $table->string('weekdays')->nullable();
            $table->string('weekends')->nullable();
            $table->string('public_holidays')->nullable();

            // social media
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();

            // google maps
            $table->smallInteger('zoom_level')->nullable();
            $table->string('latitude', '50')->nullable();
            $table->string('longitude', '50')->nullable();

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
        Schema::dropIfExists('settings');
    }
};
