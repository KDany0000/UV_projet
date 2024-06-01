<?php

use App\Models\TblCollaborateur;
use App\Models\TblProjet;
use App\Models\TblSuperviseur;
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
        Schema::create('tbl_projet_superviseurs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TblSuperviseur::class)->constrained();
            $table->foreignIdFor(TblProjet::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_projet_superviseurs');
    }
};
