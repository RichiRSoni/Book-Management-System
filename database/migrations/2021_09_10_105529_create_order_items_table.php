<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('orderItemId');
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('book_id')->index();
            $table->unsignedInteger('quantity');
            $table->decimal('price', 20, 6);

          //  $table->foreign('order_id')->references('orderId')->on('orders')->onDelete('cascade');
          //  $table->foreign('book_id')->references('bookId')->on('book_management')->onDelete('cascade');


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
        Schema::dropIfExists('order_items');
    }
}
