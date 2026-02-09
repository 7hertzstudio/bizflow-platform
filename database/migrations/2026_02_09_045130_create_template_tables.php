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
        Schema::create('template_contracts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->text('content');
            $table->json('variables')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('template_quotes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->text('introduction_template')->nullable();
            $table->text('terms_template')->nullable();
            $table->json('placeholders')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add FK back to contracts table now that templates exist
        Schema::table('tenant_contracts', function (Blueprint $table) {
            $table->foreignUlid('template_contract_id')->after('id')->nullable()->constrained('template_contracts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_contracts', function (Blueprint $table) {
            $table->dropForeign(['template_contract_id']);
            $table->dropColumn(['template_contract_id']);
        });
        
        Schema::dropIfExists('template_quotes');
        Schema::dropIfExists('template_contracts');
    }
};