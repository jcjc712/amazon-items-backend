<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asin',20);
            $table->string('detailPageURL', 250)->nullable();
            $table->string('smallImage', 250)->nullable();
            $table->string('largeImage', 250)->nullable();
            $table->string('price', 20)->nullable();
            $table->string('offerPrice', 20)->nullable();
            $table->string('pages',15)->nullable();
            $table->string('title',250)->nullable();
            $table->string('studio',200)->nullable();
            $table->string('author',100)->nullable();
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
        Schema::dropIfExists('items');
    }
}
