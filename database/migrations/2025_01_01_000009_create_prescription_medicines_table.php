<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescription_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medicine_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('generic_id')->nullable()->constrained('generics')->nullOnDelete();

            // Snapshots: old prescriptions stay unchanged if the medicine is edited later
            $table->string('brand_name', 191);
            $table->string('generic_name', 191)->nullable();
            $table->string('strength', 100)->nullable();
            $table->string('dosage_form', 50)->nullable();

            $table->string('dose', 100)->nullable();          // e.g. ১+০+১
            $table->string('timing', 100)->nullable();        // e.g. খাওয়ার পরে
            $table->string('duration', 100)->nullable();      // e.g. ৭ দিন
            $table->string('instruction', 255)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['prescription_id', 'sort_order']);
            $table->index('generic_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_medicines');
    }
};
