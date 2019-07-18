<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestChangeOwner extends Model
{
    protected $fillable = [
        'install_microchip_breed',
        'install_microchip_color',
        'install_microchip_sex',
        'install_microchip_no',
        'old_owner_name',
        'old_owner_tel_no',
        'old_owner_house_no',
        'old_owner_village_no',
        'old_owner_lane',
        'old_owner_road',
        'old_owner_province',
        'old_owner_amphures',
        'old_owner_districts',
        'old_owner_post_no',
        'request_change_owner_name',
        'request_change_owner_tel_no',
        'request_change_owner_house_no',
        'request_change_owner_village_no',
        'request_change_owner_lane',
        'request_change_owner_road',
        'request_change_owner_province',
        'request_change_owner_amphures',
        'request_change_owner_districts',
        'request_change_owner_post_no',
        'request_change_owner_status',
        'install_microchip_id',
        'microchip_id',
        'dog_id',
    ];
}
