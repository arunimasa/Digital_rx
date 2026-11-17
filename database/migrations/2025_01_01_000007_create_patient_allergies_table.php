<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_allergies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('generic_id')->nullable()->constrained('generics')->nullOnDelete();
            $table->string('allergen_name', 191);
            $table->string('reaction_note', 255)->nullable();
            $table->timestamps();

            $table->index(['patient_id', 'generic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_allergies');
    }
};
