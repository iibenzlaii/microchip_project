<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sell_dog')->nullable();
            $table->decimal('sell_dog_buy_price',8 ,0)->nullable();
            $table->decimal('sell_dog_sell_price',8 ,0)->nullable();
            $table->decimal('sell_dog_discount_price',8 ,0)->nullable();
            $table->string('sell_microchip')->nullable();
            $table->decimal('sell_microchip_buy_price',8 ,0)->nullable();
            $table->decimal('sell_microchip_sell_price',8 ,0)->nullable();
            $table->decimal('sell_microchip_discount_price',8 ,0)->nullable();
            $table->string('sell_cus_name');
            $table->string('sell_cus_tel_no');
            $table->text('sell_cus_address');
            $table->decimal('sell_transport_price',8 ,0);
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
        Schema::dropIfExists('sells');
    }
}
