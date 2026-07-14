<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id('vente_id');
	    $table->date('date');
	    $table->decimal('montant', 10, 2);
	    $table->decimal('cout', 10, 2);
	    $table->decimal('benefice', 10, 2);
	    $table->foreignId('pole_id')
      ->constrained('poles', 'pole_id')
      ->onDelete('cascade');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
