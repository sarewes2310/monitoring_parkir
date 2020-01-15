<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ParkirTableSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i=0; $i < 30; $i++) { 
            DB::table('parkir')->insert([
                'pengguna_id' => $faker->numberBetween(1, 550),
                'tempatparkir_id' => $faker->numberBetween(1, 3),
                'status' => Str::random(60),
                'verifikasi' => rand(0,1),
            ]);
        }
    }
}
