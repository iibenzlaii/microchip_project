<?php

use Illuminate\Database\Seeder;
use App\Dog;

class DogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีดำ',
            'dog_sex' => 'ตัวเมีย',
            'dog_birth_date' => '2019-04-12',
            'dog_farm_name' => 'TinyDog',
            'dog_buy_price' => '5000',
            'dog_sell_price' => '7500',
            'dog_image' => 'pom_black1.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีขาว',
            'dog_sex' => 'ตัวเมีย',
            'dog_birth_date' => '2019-01-20',
            'dog_farm_name' => 'TinyDog',
            'dog_buy_price' => '4500',
            'dog_sell_price' => '7000',
            'dog_image' => 'pom_white1.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีน้ำตาลอ่อน',
            'dog_sex' => 'ตัวเมีย',
            'dog_birth_date' => '2019-06-18',
            'dog_farm_name' => 'ChickDog',
            'dog_buy_price' => '5000',
            'dog_sell_price' => '7500',
            'dog_image' => 'pom_brownwhite1.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีน้ำตาล',
            'dog_sex' => 'ตัวผู้',
            'dog_birth_date' => '2019-05-10',
            'dog_farm_name' => 'ChickDog',
            'dog_buy_price' => '5500',
            'dog_sell_price' => '8000',
            'dog_image' => 'pom_brown1.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีขาว',
            'dog_sex' => 'ตัวผู้',
            'dog_birth_date' => '2019-06-18',
            'dog_farm_name' => 'TinyDog',
            'dog_buy_price' => '5500',
            'dog_sell_price' => '8000',
            'dog_image' => 'pom_white2.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีน้ำตาล',
            'dog_sex' => 'ตัวผู้',
            'dog_birth_date' => '2019-06-20',
            'dog_farm_name' => 'ChickDog',
            'dog_buy_price' => '5700',
            'dog_sell_price' => '8500',
            'dog_image' => 'pom_brown2.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีดำอ่อน',
            'dog_sex' => 'ตัวเมีย',
            'dog_birth_date' => '2019-06-20',
            'dog_farm_name' => 'CutePet',
            'dog_buy_price' => '6000',
            'dog_sell_price' => '9000',
            'dog_image' => 'pom_blackwhite1.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีขาวลายน้ำตาล',
            'dog_sex' => 'ตัวเมีย',
            'dog_birth_date' => '2019-06-20',
            'dog_farm_name' => 'TinyDog',
            'dog_buy_price' => '6000',
            'dog_sell_price' => '9000',
            'dog_image' => 'pom_brownwhite3.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีน้ำตาล',
            'dog_sex' => 'ตัวเมีย',
            'dog_birth_date' => '2019-06-30',
            'dog_farm_name' => 'CutePet',
            'dog_buy_price' => '5000',
            'dog_sell_price' => '7000',
            'dog_image' => 'pom_brown2.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);

        Dog::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_color' => 'สีขาวลายน้ำตาล',
            'dog_sex' => 'ตัวผู้',
            'dog_birth_date' => '2019-04-10',
            'dog_farm_name' => 'ChickDog',
            'dog_buy_price' => '6000',
            'dog_sell_price' => '8900',
            'dog_image' => 'pom_brownwhite4.jpg',
            'dog_status' => '0',
            'install_status' => '0',
        ]);
    }
}
