<?php

use App\Models\TblFaculte;
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
        Schema::create('tbl_filieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom_fil')->unique();
            $table->foreignIdFor(TblFaculte::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_filieres');
    }
};
