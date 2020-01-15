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
        // $this->call(UsersTableSeeder::class);
        $this->call('UsersTableSeeder');
        $this->call('AccessTableSeeeder');
        $this->call('ParkirTableSeeeder');
        $this->call('PenggunaTableSeeder');
        $this->call('StatusPenggunaTableSeeeder');
        $this->call('TempatParkirTableSeeeder');
    }
}
