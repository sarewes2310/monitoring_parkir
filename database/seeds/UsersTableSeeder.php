<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=0; $i < 50; $i++) { 
            DB::table('users')->insert([
                'name' => $faker->name,
                'notelp' => $faker->e164PhoneNumber,
                'username' => $faker->name,
                'password' => $faker->name,
                'idAccess' => 1,
            ]);
        }
    }
}
