<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valasz extends Model
{

    public function kerdes()
    {
        return $this->belongsTo('App\Kerdes');
    }

    public function valaszLehetoseg()
    {
        return $this->belongsTo('App\ValaszLehetoseg');
    }

    public function vizsgazas()
    {
        return $this->belongsTo('App\Vizsgazas');
    }

}
