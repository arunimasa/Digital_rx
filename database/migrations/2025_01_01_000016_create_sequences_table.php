<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Use inside a DB transaction with lockForUpdate() to avoid duplicate numbers.
        Schema::create('sequences', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);                              // 'patient', 'rx'
            $table->unsignedSmallInteger('year')->default(0);        // 0 = never resets
            $table->unsignedBigInteger('last_number')->default(0);
            $table->timestamps();

            $table->unique(['name', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sequences');
    }
};
