<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 2 ,
            'nom' => 'ENSIASD',
            'prenom' => 'etudiant',
            'email' => 'etudiant@ensiasd.com',
            'password' => Hash::make('etudiant123'),
            'role' => 'etudiant',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
