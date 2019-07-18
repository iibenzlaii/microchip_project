<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('dog_breed');
            $table->string('dog_color');
            $table->string('dog_sex');
            $table->string('dog_birth_date');
            $table->char('dog_farm_name');
            $table->decimal('dog_buy_price',8,0);
            $table->decimal('dog_sell_price',8,0);
            $table->string('dog_image')->nullable();
            $table->string('dog_owner')->nullable();
            $table->char('dog_status',1);
            $table->char('install_status',1);
            $table->char('microchip_id')->nullable();
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
        Schema::dropIfExists('dogs');
    }
}
