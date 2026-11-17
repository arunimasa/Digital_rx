<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('rx_number', 30)->unique();
            $table->foreignId('patient_id')->constrained()->restrictOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->restrictOnDelete();
            $table->date('visit_date');
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->enum('language', ['bn', 'en'])->default('bn');

            // Clinical notes
            $table->text('complaints')->nullable();

            // Vitals
            $table->unsignedSmallInteger('bp_systolic')->nullable();
            $table->unsignedSmallInteger('bp_diastolic')->nullable();
            $table->unsignedSmallInteger('pulse')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();   // e.g. 101.5
            $table->decimal('weight', 5, 2)->nullable();        // kg
            $table->decimal('height', 5, 1)->nullable();        // cm
            $table->unsignedTinyInteger('spo2')->nullable();    // %
            $table->unsignedTinyInteger('resp_rate')->nullable();

            $table->text('diagnosis')->nullable();
            $table->text('advice')->nullable();
            $table->date('next_visit_date')->nullable();

            $table->foreignId('copied_from_id')->nullable()->constrained('prescriptions')->nullOnDelete();
            $table->string('qr_token', 64)->unique();
            $table->timestamp('finalized_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'visit_date']);
            $table->index(['doctor_id', 'status', 'visit_date']);
            $table->index('visit_date');
            $table->index('next_visit_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
