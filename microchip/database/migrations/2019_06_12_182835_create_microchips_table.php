<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrochipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microchips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('microchip_no');
            $table->decimal('microchip_buy_price',8,0);
            $table->decimal('microchip_sell_price',8,0);
            $table->string('microchip_owner')->nullable();
            $table->char('microchip_status',1);
            $table->char('install_status',1);
            $table->char('dog_id')->nullable();
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
        Schema::dropIfExists('microchips');
    }
}
