<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class StatusPenggunaTableSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['mahasiswa','pegawai'];
        foreach($data as $item)
        {
            DB::table('status_pengguna')->insert([
                'nama_status_pengguna' => $item,
            ]);
        }
    }
}
