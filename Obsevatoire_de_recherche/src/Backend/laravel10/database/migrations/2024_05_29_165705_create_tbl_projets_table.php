<?php

use App\Models\TblCategorie;
use App\Models\TblNiveau;
use App\Models\User;
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
        Schema::create('tbl_projets', function (Blueprint $table) {
            $table->id();
            $table->string('titre_projet')->unique();
            $table->text('descript_projet');
            $table->text('superviseurs');
            $table->foreignIdFor(TblNiveau::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(TblCategorie::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_projets');
    }
};
