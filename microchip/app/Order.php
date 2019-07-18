<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_dog', 
        'order_dog_buy_price', 
        'order_dog_sell_price', 
        'order_dog_discount_price', 
        'order_microchip', 
        'order_microchip_buy_price', 
        'order_microchip_sell_price', 
        'order_microchip_discount_price', 
        'order_cus_name',
        'order_cus_tel_no',
        'order_cus_house_no',
        'order_cus_village_no',
        'order_cus_lane',
        'order_cus_road',
        'order_cus_province',
        'order_cus_amphures',
        'order_cus_districts',
        'order_cus_post_no',
        'order_deliveryman', 
        'order_send_time', 
        'order_receive_time', 
        'order_transport', 
        'order_transport_price', 
        'order_tracking_no', 
        'order_type',
        'order_status',
        'dog_id',
        'microchip_id',
    ];
}