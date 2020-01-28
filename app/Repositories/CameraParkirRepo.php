<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class CameraParkirRepo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'camera_parkir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip', 'tipe',
    ];
}
