<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class PenggunaRepo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengguna';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fakultas', 'statuspengguna_id', 'nama_pengguna', 'cid', 'nim_nip', 'alamat', 'foto', 'id'
    ];
}
