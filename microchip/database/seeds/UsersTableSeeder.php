<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('1234'),
            'type' => 'Admin',
        ]);

        User::create([
            'name' => 'Deliveryman 1',
            'email' => 'deliveryman1@mail.com',
            'password' => bcrypt('1234'),
            'type' => 'Deliveryman',
        ]);

        User::create([
            'name' => 'Deliveryman 2',
            'email' => 'deliveryman2@mail.com',
            'password' => bcrypt('1234'),
            'type' => 'Deliveryman',
        ]);

        User::create([
            'name' => 'Member',
            'email' => 'member@mail.com',
            'password' => bcrypt('1234'),
            'type' => 'Member',
        ]);
    }
}
