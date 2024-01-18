<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description') -> nullable(true);
            $table->integer('price') -> nullable(true);
            $table->string('link') -> nullable(true);
            $table->string('image') -> nullable(true);
            $table->integer('wishlist_id');
            $table->boolean('IsReserved')-> default(false);
            $table->boolean('IsActive')-> default(true);
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
        Schema::dropIfExists('gift_cards');
    }
};
