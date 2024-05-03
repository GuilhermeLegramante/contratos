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
        Schema::create('addendums', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->foreignId('contract_id')->constrained('contracts')->restrictOnDelete();
            $table->foreignId('adjustment_index_id')->constrained('adjustment_indices')->restrictOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('global_value')->nullable();
            $table->double('monthly_value')->nullable();
            $table->string('file')->nullable();
            $table->double('adjustment_percentual')->nullable();
            $table->boolean('is_active')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addendums');
    }
};
