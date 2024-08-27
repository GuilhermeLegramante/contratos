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
        Schema::create('cnaes', function (Blueprint $table) {
            $table->id();
            $table->string('number')->comment('ItemListaServico');
            $table->string('code')->comment('CodigoCnae');
            $table->string('description')->comment('Descricao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnaes');
    }
};