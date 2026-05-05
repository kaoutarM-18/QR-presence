<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'nom' => 'web developpement',
                'filiere_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
               'nom' => 'OOP en JAVA',
                'filiere_id' => 1,
                'created_at' => now(),
                'updated_at' => now(), 
            ],
            [
                'nom' => 'bases de donnees avancees',
                'filiere_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'machine learning',
                'filiere_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
