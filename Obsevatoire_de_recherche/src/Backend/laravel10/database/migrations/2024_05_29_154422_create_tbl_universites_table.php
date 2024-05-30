<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_universites', function (Blueprint $table) {
            $table->id();
            $table->string('nom_univ')->unique();
            $table->string('localite_univ')->unique();
            $table->string('email_univ')->unique();
            $table->string('boite_postale')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_universites');
    }
};
