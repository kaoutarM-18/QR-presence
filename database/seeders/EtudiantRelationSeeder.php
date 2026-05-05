<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtudiantRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->where('email', 'etudiant@ensiasd.com')->first();

        DB::table('etudiants')->insert([
            'user_id' => $user->id,
            'filiere_id' => 1, // etudiant de la filiere MGSI
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
