<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_code', 20)->unique();
            $table->string('name', 150);
            $table->unsignedSmallInteger('age')->nullable();
            $table->enum('age_unit', ['years', 'months', 'days'])->default('years');
            $table->enum('sex', ['male', 'female', 'other']);
            $table->string('mobile', 20)->nullable();
            $table->text('address')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
            $table->index('mobile');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
