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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cnae_id')->nullable()->constrained('cnaes')->cascadeOnDelete();
            $table->double('value')->comment('ValorServicos');
            $table->double('aliquot')->nullable()->comment('Aliquota');
            $table->string('description')->comment('Discriminacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
