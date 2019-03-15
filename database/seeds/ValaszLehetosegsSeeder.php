<?php

use Illuminate\Database\Seeder;

class ValaszLehetosegsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids = \App\Kerdes::pluck('id')->toArray();
        
        foreach ($ids as $id)
            $this->createValaszLehetosegsForKerdesId($id);
    }

    private function createValaszLehetosegsForKerdesId($kerdesId) {
        DB::table('valasz_lehetosegs')->insert([
            'description' => '1 + 1 = 5',
            'helyes' => false,
            'kerdes_id' => $kerdesId
        ]);
        DB::table('valasz_lehetosegs')->insert([
            'description' => '1 + 2 = 78',
            'helyes' => false,
            'kerdes_id' => $kerdesId
        ]);
        DB::table('valasz_lehetosegs')->insert([
            'description' => '1 + 1 = 2',
            'helyes' => true,
            'kerdes_id' => $kerdesId
        ]);
        DB::table('valasz_lehetosegs')->insert([
            'description' => '1 + 9 = 9',
            'helyes' => false,
            'kerdes_id' => $kerdesId
        ]);
    }
}
