<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount'); // total
            $table->decimal('amount_items'); // total items
            $table->decimal('amount_tax')->nullable(); // 15% tax
            $table->decimal('amount_original')->nullable(); // total
            $table->string('token'); // token/id
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('transaction_id')->nullable(); // when linked
            $table->timestamp('linked_transaction_at')->nullable();
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
        Schema::dropIfExists('checkouts');
    }
}
