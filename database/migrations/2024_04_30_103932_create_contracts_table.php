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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            $table->foreignId('hiring_method_id')->constrained('hiring_methods')->restrictOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('global_value')->nullable();
            $table->double('monthly_value')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_active')->default(0);
            $table->integer('addendum_quantity')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
