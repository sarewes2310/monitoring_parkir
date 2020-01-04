<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PenggunaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        /*for ($i=0; $i < 250; $i++) { 
            DB::table('pengguna')->insert([
                'nama_pengguna' => $faker->name,
                'fakultas' => Str::random(10),
                'idStatusPengguna' => $faker->numberBetween(1,2),
                'cid' => $faker->uuid,
                'nim_nip' => $faker->ean8,
                'alamat' => $faker->address,
                'foto' => $faker->address,
            ]);
        }*/

        for ($i=0; $i < 550; $i++) { 
            DB::table('pengguna')->insert([
                'nama_pengguna' => $faker->name,
                'fakultas' => Str::random(10),
                'idStatusPengguna' => 1,
                'cid' => $faker->uuid,
                'nim_nip' => $faker->ean8,
                'alamat' => $faker->address,
                'foto' => $faker->address,
            ]);
        }
    }
}
