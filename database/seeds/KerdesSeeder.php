<?php

use Illuminate\Database\Seeder;

class KerdesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kerdes')->insert([
            'description' => 'Jelöld ki a helyes választ!',
            'kerdesszam' => 1,
            'vizsga_id' => 1
        ]);
        DB::table('kerdes')->insert([
            'description' => 'Jelöld ki a helyes választ!',
            'kerdesszam' => 2,
            'vizsga_id' => 1
        ]);
        DB::table('kerdes')->insert([
            'description' => 'Jelöld ki a helyes választ!',
            'kerdesszam' => 3,
            'vizsga_id' => 1
        ]);
    }
}
