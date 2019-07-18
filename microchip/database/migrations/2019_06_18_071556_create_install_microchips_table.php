<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallMicrochipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('install_microchips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('install_microchip_breed');
            $table->string('install_microchip_color');
            $table->string('install_microchip_sex');
            $table->string('install_microchip_birth_date')->nullable();
            $table->string('install_microchip_image')->nullable();
            $table->string('install_microchip_owner_name');
            $table->string('install_microchip_owner_tel_no');
            $table->string('install_microchip_owner_house_no');
            $table->string('install_microchip_owner_village_no');
            $table->string('install_microchip_owner_lane');
            $table->string('install_microchip_owner_road');
            $table->string('install_microchip_owner_province');
            $table->string('install_microchip_owner_amphures');
            $table->string('install_microchip_owner_districts')->nullable();
            $table->string('install_microchip_owner_post_no');
            $table->string('install_microchip_booking_date')->nullable();
            $table->string('install_microchip_no');
            $table->char('install_microchip_status',1);
            $table->char('microchip_id');
            $table->char('dog_id')->nullable();
            $table->char('user_id')->nullable();
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
        Schema::dropIfExists('install_microchips');
    }
}
