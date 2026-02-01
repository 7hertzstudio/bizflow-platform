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
        Schema::create('tenant_domains', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            $table->string('domain')->unique();
            $table->boolean('is_verified')->default(false);
            $table->string('verification_token')->nullable();
            $table->json('dns_settings')->nullable(); // For future Cloudflare integration
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_domains');
    }
};