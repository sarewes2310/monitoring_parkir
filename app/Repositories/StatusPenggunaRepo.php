<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class StatusPenggunaRepo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status_pengguna';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_status_pengguna',
    ];
}
