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

            $table->foreignId('enseignant_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('module_id')
                    ->constrained()
                    ->onDelete('cascade');

            $table->foreignId('filiere_id')
                ->nullable()
                ->constrained('filieres')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cours');
    }
};