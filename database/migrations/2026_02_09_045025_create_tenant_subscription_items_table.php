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
        Schema::create('tenant_subscription_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_subscription_id')->constrained('tenant_subscriptions')->onDelete('cascade');
            $table->foreignUlid('product_plan_id')->constrained('product_plans')->onDelete('cascade');
            $table->bigInteger('original_price'); // Snapshot in cents
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_subscription_items');
    }
};