<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstallMicrochip extends Model
{
    protected $fillable = [
        'install_microchip_breed', 
        'install_microchip_color', 
        'install_microchip_sex', 
        'install_microchip_birth_date',
        'install_microchip_image', 
        'install_microchip_owner_name', 
        'install_microchip_owner_tel_no', 
        'install_microchip_owner_house_no', 
        'install_microchip_owner_village_no', 
        'install_microchip_owner_lane', 
        'install_microchip_owner_road', 
        'install_microchip_owner_province', 
        'install_microchip_owner_amphures', 
        'install_microchip_owner_districts', 
        'install_microchip_owner_post_no', 
        'install_microchip_booking_date', 
        'install_microchip_status', 
        'install_microchip_no', 
        'microchip_id', 
        'dog_id',
        'user_id',
    ];
}
