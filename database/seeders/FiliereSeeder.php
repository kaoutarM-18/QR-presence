<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
        DB::table('filieres')->insert([
            [
                'nom_filiere' => 'MGSI',
                'nombre_etudiants' => 60 ,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_filiere' => 'SDBDIA',
                'nombre_etudiants' => 62 ,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
