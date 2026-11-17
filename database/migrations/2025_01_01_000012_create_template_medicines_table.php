<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('prescription_templates')->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->string('dose', 100)->nullable();
            $table->string('timing', 100)->nullable();
            $table->string('duration', 100)->nullable();
            $table->string('instruction', 255)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['template_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_medicines');
    }
};
