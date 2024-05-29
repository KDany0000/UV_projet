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
        Schema::create('tbl_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nom_doc');
            $table->string('lien_doc')->unique();
            $table->string('type_doc');
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
