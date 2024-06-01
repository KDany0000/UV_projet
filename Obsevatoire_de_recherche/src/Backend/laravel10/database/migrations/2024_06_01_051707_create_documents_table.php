<?php

use App\Models\TblProjet;
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
        Schema::create('tbl_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nom_doc');
            $table->string('lien_doc')->unique();
            $table->enum('type_doc', ['PDF', 'WORD', 'POWERPOINT'])->default('PDF');
            $table->foreignIdFor(TblProjet::class)->constrained();
            $table->text('resume');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_documents');
    }
};
