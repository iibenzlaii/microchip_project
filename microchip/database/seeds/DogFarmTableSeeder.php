<?php

use Illuminate\Database\Seeder;
use App\DogFarm;

class DogFarmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DogFarm::create([
            'dog_farm_name' => 'ChickDog',
            'dog_farm_count' => '4',
        ]);

        DogFarm::create([
            'dog_farm_name' => 'TinyDog',
            'dog_farm_count' => '4',
        ]);

        DogFarm::create([
            'dog_farm_name' => 'CutePet',
            'dog_farm_count' => '2',
        ]);
    }
}
