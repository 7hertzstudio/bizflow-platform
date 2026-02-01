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
        Schema::create('tenant_subscriptions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            $table->foreignUlid('tenant_plan_id')->constrained('tenant_plans')->onDelete('cascade');
            
            // Snapshot of price at time of subscription (handles conversion/rounding/custom deals)
            $table->decimal('price_at_subscription', 15, 2);
            $table->string('currency_at_subscription');
            $table->decimal('exchange_rate_used', 15, 6)->default(1.0);
            
            $table->string('status')->default('active'); // active, past_due, canceled, expired
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_subscriptions');
    }
};