<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class ParkirRepo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parkir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pengguna_id', 'tempatparkir_id', 'foto', 'verifikasi'
    ];
}
