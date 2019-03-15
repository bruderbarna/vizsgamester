<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kerdes extends Model
{

    public function valaszLehetosegs()
    {
        return $this->hasMany('App\ValaszLehetoseg');
    }

    public function vizsga()
    {
        return $this->belongsTo('App\Vizsga');
    }

}
