<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(WebpageTableSeeder::class);
        $this->call(DogFarmTableSeeder::class);
        $this->call(DogBreedTableSeeder::class);
        $this->call(DogTableSeeder::class);
        $this->call(MicrochipTableSeeder::class);
        $this->call(TransportSeeder::class);
    }
}
