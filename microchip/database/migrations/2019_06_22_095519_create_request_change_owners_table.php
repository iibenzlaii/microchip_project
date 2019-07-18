<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestChangeOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_change_owners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('install_microchip_breed');
            $table->string('install_microchip_color');
            $table->string('install_microchip_sex');
            $table->string('install_microchip_no');
            $table->string('old_owner_name');
            $table->string('old_owner_tel_no');
            $table->string('old_owner_house_no');
            $table->string('old_owner_village_no');
            $table->string('old_owner_lane');
            $table->string('old_owner_road');
            $table->string('old_owner_province');
            $table->string('old_owner_amphures');
            $table->string('old_owner_districts');
            $table->string('old_owner_post_no');
            $table->string('request_change_owner_name');
            $table->string('request_change_owner_tel_no');
            $table->string('request_change_owner_house_no');
            $table->string('request_change_owner_village_no');
            $table->string('request_change_owner_lane');
            $table->string('request_change_owner_road');
            $table->string('request_change_owner_province');
            $table->string('request_change_owner_amphures');
            $table->string('request_change_owner_districts');
            $table->string('request_change_owner_post_no');
            $table->string('request_change_owner_status');
            $table->char('install_microchip_id');
            $table->char('microchip_id');
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
        Schema::dropIfExists('request_change_owners');
    }
}
