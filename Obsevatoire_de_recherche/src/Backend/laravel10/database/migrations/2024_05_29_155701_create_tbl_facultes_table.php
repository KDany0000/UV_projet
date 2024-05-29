<?php

use App\Models\TblUniversite;
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
        Schema::create('tbl_facultes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_fac')->unique();
            $table->string('email_fac')->unique();
            $table->foreignIdFor(TblUniversite::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_facultes');
    }
};
