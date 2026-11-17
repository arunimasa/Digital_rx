<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('name_en', 150);
            $table->string('name_bn', 150)->nullable();
            $table->text('degrees');
            $table->string('specialty', 150)->nullable();
            $table->string('bmdc_no', 50)->unique();
            $table->string('chamber_name', 191)->nullable();
            $table->text('chamber_address')->nullable();
            $table->string('chamber_phone', 50)->nullable();
            $table->string('visiting_hours', 255)->nullable();
            $table->string('signature_path')->nullable();
            $table->string('logo_path')->nullable();
            $table->enum('default_paper_size', ['A4', 'A5'])->default('A4');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
