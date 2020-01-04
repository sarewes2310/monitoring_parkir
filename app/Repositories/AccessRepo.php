<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class AccessRepo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'access';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_access', 
    ];
}
