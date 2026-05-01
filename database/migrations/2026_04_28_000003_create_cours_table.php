<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create('cours', function (Blueprint $table) {
    $table->id();
    $table->string('nom_cours');
    $table->text('description')->nullable();
    $table->foreignId('enseignant_id')->constrained('users')->onDelete('cascade');
    $table->unsignedBigInteger('id_module')->nullable();
    $table->foreign('id_module')->references('id_module')->on('modules')->onDelete('cascade');
    $table->unsignedBigInteger('id_filiere')->nullable(); // ✅ ajouté
    $table->foreign('id_filiere')->references('id_filiere')->on('filieres')->onDelete('set null');
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('cours');
    }
};