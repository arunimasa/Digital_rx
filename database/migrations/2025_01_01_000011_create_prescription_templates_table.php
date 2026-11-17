<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescription_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->string('name', 150);
            $table->text('complaints')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('advice')->nullable();
            $table->boolean('is_shared')->default(false);
            $table->timestamps();

            $table->index(['doctor_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_templates');
    }
};
