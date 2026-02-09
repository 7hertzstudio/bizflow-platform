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
        Schema::create('tenant_credentials', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            
            // Polymorphic reference
            $table->ulid('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            
            $table->string('label'); // WordPress Admin, cPanel
            $table->string('login_url')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->text('password'); // Encrypted
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_credentials');
    }
};