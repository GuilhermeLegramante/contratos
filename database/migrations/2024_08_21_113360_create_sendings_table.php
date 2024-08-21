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
        Schema::create('sendings', function (Blueprint $table) {
            $table->id();
            $table->integer('situation')->nullable()->comment('Situacao');
            $table->string('number')->comment('NumeroLote');
            $table->dateTime('date')->comment('DataRecebimento');
            $table->string('protocol')->comment('Protocolo');
            $table->date('emission_date')->nullable('DataEmissao');
            $table->text('info')->nullable()->comment('OutrasInformacoes');
            $table->double('value')->nullable()->comment('BaseCalculo');
            $table->double('aliquot')->nullable()->comment('Aliquota');
            $table->double('iss_value')->nullable()->comment('ValorIss');
            $table->double('net_value')->nullable()->comment('ValorLiquidoNfse');
            $table->integer('rps')->nullable()->comment('RPS');
            $table->date('competence_date')->nullable()->comment('Competência');
            $table->foreignId('contract_id')->nullable()->comment('Tomador (a partir do contrato)')->constrained('contracts')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sendings');
    }
};
