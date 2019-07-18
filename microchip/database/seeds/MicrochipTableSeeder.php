<?php

use Illuminate\Database\Seeder;
use App\Microchip;

class MicrochipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Microchip::create([
            'microchip_no' => '658HI4DH1ZLRU',
            'microchip_buy_price' => '500',
            'microchip_sell_price' => '1000',
            'microchip_status' => '0',
            'install_status' => '0',
        ]);

        Microchip::create([
            'microchip_no' => '5U5QZP5B8PO3E',
            'microchip_buy_price' => '400',
            'microchip_sell_price' => '800',
            'microchip_status' => '0',
            'install_status' => '0',
        ]);

        Microchip::create([
            'microchip_no' => '96AGXC8OJ9LYW',
            'microchip_buy_price' => '300',
            'microchip_sell_price' => '600',
            'microchip_status' => '0',
            'install_status' => '0',
        ]);

        Microchip::create([
            'microchip_no' => 'K9FV1YEP0VVJG',
            'microchip_buy_price' => '400',
            'microchip_sell_price' => '800',
            'microchip_status' => '0',
            'install_status' => '0',
        ]);

        Microchip::create([
            'microchip_no' => '3BWCL1G04Q5V8',
            'microchip_buy_price' => '300',
            'microchip_sell_price' => '600',
            'microchip_status' => '0',
            'install_status' => '0',
        ]);
    }
}
