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
        Schema::create('project_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tbl_projet_id');
            $table->string('ip_address');
            $table->timestamps();

            $table->foreign('tbl_projet_id')->references('id')->on('tbl_projets')->onDelete('cascade');
            $table->unique(['tbl_projet_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_views');
    }
};
