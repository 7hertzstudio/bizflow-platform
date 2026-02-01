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
        Schema::create('tenant_business_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('tenant_business_id')->unique()->constrained('tenant_businesses')->onDelete('cascade');
            $table->string('logo')->nullable();
            $table->json('theme')->nullable(); // Colors, font, etc.
            $table->json('billing_info')->nullable(); // Custom address for billing if different from company
            $table->json('notification_settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_business_settings');
    }
};