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
        Schema::create('leads', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('source')->default('web');
            $table->string('status')->default('new'); // new, contacted, qualified, converted, lost
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Link quotes to leads properly
        Schema::table('tenant_quotes', function (Blueprint $table) {
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_quotes', function (Blueprint $table) {
            $table->dropForeign(['lead_id']);
        });
        Schema::dropIfExists('leads');
    }
};