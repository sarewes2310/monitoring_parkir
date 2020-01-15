<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class TempatParkirTableSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=0; $i < 3; $i++) { 
            DB::table('tempat_parkir')->insert([
                'nama_tempat_parkir' => $faker->name,
                'alamat' => $faker->address,
            ]);
        }
    }
}
