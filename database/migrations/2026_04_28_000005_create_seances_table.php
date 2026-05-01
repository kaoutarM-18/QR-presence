<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('seances', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cours_id')->constrained()->onDelete('cascade');
    $table->datetime('date_heure');
    $table->integer('duree'); 
    $table->string('type')->default('Cours');
    $table->boolean('qr_expire')->default(true);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
};
