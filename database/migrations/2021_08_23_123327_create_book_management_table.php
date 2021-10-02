<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::rename('book_management', 'Book');
        // Schema::create('book_management', function (Blueprint $table) {
        //     $table->increments('bookId');
        //     //$table->id('bookId');
        //     $table->string('bookName');
        //     $table->string('bookAuthor');
        //     $table->string('bookDetails');
        //     $table->bigInteger('bookPrice');
        //     $table->integer('bookQty');
        //     $table->string('bookImage');
        //     $table->timestamps();

           
        // });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::dropIfExists('book_management');
    }
}
