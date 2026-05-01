<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
     Schema::create('etudiants', function (Blueprint $table) {
    $table->id();
    $table->string('nom');
    $table->string('prenom');
    $table->string('email')->unique();
    $table->string('password');
    $table->unsignedBigInteger('id_filiere')->nullable(); // ✅ ajouté
    $table->foreign('id_filiere')
          ->references('id_filiere')
          ->on('filieres')
          ->onDelete('set null');
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};