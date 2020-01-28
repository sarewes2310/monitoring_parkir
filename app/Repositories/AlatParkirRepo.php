<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\TempatParkirRepo;

class AlatParkirRepo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alat_parkir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mac', 'mode', 'token', 'tipe'
    ];

    public function rolesku()
    {
        return $this->belongsToMany(TempatParkirRepo::class);
    }
}
