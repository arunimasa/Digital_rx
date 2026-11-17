<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name', 191);
            $table->foreignId('generic_id')->nullable()->constrained('generics')->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->string('strength', 100)->nullable();
            $table->string('dosage_form', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Autocomplete uses brand_name LIKE 'abc%'
            $table->index('brand_name');
            $table->index(['brand_name', 'strength', 'dosage_form', 'company_id'], 'medicines_import_lookup_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
