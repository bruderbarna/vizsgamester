<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vizsgazas extends Model
{

    public function vizsga()
    {
        return $this->belongsTo('App\Vizsga');
    }

    public function valaszs()
    {
        return $this->hasMany('App\Valasz');
    }

    public function canContinue()
    {
        $kezdet = new \DateTime($this->attributes['kezdet']);
        $kezdetPluszIdotartam = $kezdet->modify("+{$this->vizsga->vizsga_idotartam} minutes");

        return new \DateTime() < $kezdetPluszIdotartam;
    }

    public function getElertPontszam()
    {
        return $this
            ->valaszs
            ->filter(function ($valasz) { return $valasz->valaszLehetoseg->helyes === 1; })
            ->count();
    }

    public function getSzazalek()
    {
        return ($this->getElertPontszam() / $this->vizsga->kerdes->count()) * 100;
    }

    public function getJegy()
    {
        $szazalek = $this->getSzazalek();

        if ($szazalek < 50)
            return 1;
        else if ($szazalek < 62.5)
            return 2;
        else if ($szazalek < 75)
            return 3;
        else if ($szazalek < 87.5)
            return 4;
        else
            return 5;
    }

}
