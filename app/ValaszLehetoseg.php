<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValaszLehetoseg extends Model
{

    public function kerdes()
    {
        return $this->belongsTo('App\Kerdes');
    }

}
