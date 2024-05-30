<?php
use App\Models\TblProjet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TblCollaborateur;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_collaborateur_projets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TblCollaborateur::class)->constrained();
            $table->foreignIdFor(TblProjet::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_collaborateur_projets');
    }
};
