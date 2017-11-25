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
            $table->string('detailUrl', 150);
            $table->string('smallImageUrl', 150);
            $table->string('largeImageUrl', 150);
            $table->decimal('price', 8, 2);
            $table->decimal('offerPrice', 8, 2);
            $table->string('pages',150);
            $table->string('title',150);
            $table->string('studio',200);
            $table->string('author',100);
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
