<?php

use Illuminate\Database\Seeder;

class VizsgaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vizsgas')->insert([
            'vizsgakod' => '0123456789',
            'user_id' => 1,
            'targy_nev' => 'Diszkrét Matematika I. ea',
            'vizsga_idotartam' => 30,
            'tol' => new \DateTime('2019-03-01 10:00'),
            'ig' => new \DateTime('2019-05-01 15:00')
        ]);
    }
}
