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
        Schema::create('tenant_businesses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('billing_currency')->default('USD');
            $table->string('country')->nullable();
            $table->string('status')->default('active'); // active, suspended, trial
            $table->timestamps();
        });

        // Pivot table for multiple users per business
        Schema::create('tenant_business_user', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role')->default('tenant_admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_business_user');
        Schema::dropIfExists('tenant_businesses');
    }
};