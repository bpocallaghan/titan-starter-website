<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogProductSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_product_searches', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->integer('searchable_id')->unsigned()->index()->nullable();
            $table->string('searchable_type')->index()->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('created_by')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_product_searches');
    }
}
