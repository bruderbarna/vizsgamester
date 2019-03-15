<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vizsga extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function vizsgazass()
    {
        return $this->hasMany('App\Vizsgazas');
    }

    public function kerdes()
    {
        return $this->hasMany('App\Kerdes');
    }

    public function earlyToTake()
    {
        return new \DateTime() < new \DateTime($this->attributes['tol']);
    }
    
    public function lateToTake()
    {
        return new \DateTime() > new \DateTime($this->attributes['ig']);
    }

    public function canTakeNow()
    {
        $now = new \DateTime(); 
        $tol = new \DateTime($this->attributes['tol']); 
        $ig = new \DateTime($this->attributes['ig']); 
        return $now >= $tol && $now <= $ig;
    }

}
