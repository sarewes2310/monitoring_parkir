<?php

namespace App\Custom;

use Illuminate\Support\Facades\Auth;
use App\Repositories\TempatParkirRepo;

class CheckStatus 
{
    public static function check()
    {
        if(Auth::user()->access_id == 2)
        {
            return TempatParkirRepo::all();
        }else
        {
            return [];
        }
    }   
}
