<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_dog')->nullable();
            $table->decimal('order_dog_buy_price',8,0)->nullable();
            $table->decimal('order_dog_sell_price',8,0)->nullable();
            $table->decimal('order_dog_discount_price',8,0)->nullable();
            $table->string('order_microchip')->nullable();
            $table->decimal('order_microchip_buy_price',8,0)->nullable();
            $table->decimal('order_microchip_sell_price',8,0)->nullable();
            $table->decimal('order_microchip_discount_price',8,0)->nullable();
            $table->string('order_cus_name');
            $table->string('order_cus_tel_no');
            $table->string('order_cus_house_no');
            $table->string('order_cus_village_no');
            $table->string('order_cus_lane');
            $table->string('order_cus_road');
            $table->string('order_cus_province');
            $table->string('order_cus_amphures');
            $table->string('order_cus_districts')->nullable();
            $table->string('order_cus_post_no');
            $table->string('order_deliveryman');
            $table->string('order_send_time');
            $table->string('order_receive_time');
            $table->string('order_transport');
            $table->decimal('order_transport_price',8,0);
            $table->string('order_tracking_no')->nullable();
            $table->char('order_type',1);
            $table->char('order_status',1);
            $table->char('dog_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
