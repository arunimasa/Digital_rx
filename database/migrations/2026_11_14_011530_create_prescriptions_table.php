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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('rx_no', 30)->unique();
            $table->foreignId('patient_id')->constrained('patients')->restrictOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->restrictOnDelete();
            $table->enum('status', ['draft', 'final'])->default('draft')->index();
            $table->text('complaints')->nullable();
            $table->json('vitals')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('tests')->nullable();
            $table->json('medicines')->nullable();
            $table->text('advice')->nullable();
            $table->date('next_visit')->nullable()->index();
            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
