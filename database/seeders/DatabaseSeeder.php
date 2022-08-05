<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('lt_LT');

        //user seeder
        DB::table('users')->insert([
            'name' => 'Briedis',
            'email' => 'briedis@gmail.com',
            'password' => Hash::make('123'),
            'role' => 10,
        ]);

        DB::table('users')->insert([
            'name' => 'Bebras',
            'email' => 'bebras@gmail.com',
            'password' => Hash::make('123'),
        ]);

        foreach(range(1, 9) as $_) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->freeEmail,
                'password' => Hash::make('123'),
            ]);
        }

        //country seeder
        $countries = collect([]);
        do {
            $countries->push($faker->country);
            $countries = $countries->unique();
        } while ($countries->count() < 10);

        $season = ['Winter', 'Spring', 'Summer', 'Autumn'];

        foreach($countries as $country) {
            DB::table('countries')->insert([
                'country_name' => $country,
                'season_time' => $season[rand(0, 3)],
            ]);
        }

        //hotel seeder
        $hotels = collect([]);
        do {
            $hotels->push($faker->company);
            $hotels = $hotels->unique();
        } while ($hotels->count() < 20);

        foreach($hotels as $hotel) {
            DB::table('hotels')->insert([
                'country_id' => rand(1, 10),
                'hotel_name' => $hotel,
                'price' => rand(20, 1000),
                'image' => $faker->imageUrl($width = 640, $height = 480, 'hotel') ,
                'trip_time' => rand(1, 14),
            ]);
        }

        //order seeder
        foreach(range(1, 9) as $_) {
            DB::table('orders')->insert([
                'hotel_id' => rand(1, 20),
                'user_id' => rand(1, 11),
            ]);
        }
        
    }
}
