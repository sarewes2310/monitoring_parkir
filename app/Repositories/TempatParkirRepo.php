<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\AlatParkirRepo;

class TempatParkirRepo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tempat_parkir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_tempat_parkir', 'alamat',
    ];

    public function rolesku()
    {
        return $this->belongsToMany(AlatParkirRepo::class);
    }

    public function parkir()
    {
        return $this->hasMany('App\Repositories\ParkirRepo', 'tempatparkir_id', 'id');
    }
    
}
