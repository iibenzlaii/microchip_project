<?php

use Illuminate\Database\Seeder;
use App\DogBreed;

class DogBreedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DogBreed::create([
            'dog_breed' => 'ปอมเมอเรเนียน',
            'dog_breed_male_count' => '4',
            'dog_breed_female_count' => '6',
        ]);
    }
}
