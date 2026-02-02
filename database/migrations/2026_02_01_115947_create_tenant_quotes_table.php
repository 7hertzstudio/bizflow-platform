<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_quotes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            
            // Reference
            $table->string('reference_number')->unique(); // Q-10001
            
            // Currency & Pricing (Header Level)
            $table->string('currency')->default('USD');
            $table->decimal('exchange_rate', 15, 6)->default(1.0);
            
            // Master Discount Logic
            $table->boolean('has_master_discount')->default(false);
            $table->string('master_discount_type')->default('percentage'); // percentage, fixed
            $table->decimal('master_discount_value', 15, 2)->default(0);
            
            // Totals
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_total', 15, 2)->default(0);
            $table->decimal('tax_total', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);

            // Status
            $table->string('status')->default('draft'); // draft, sent, accepted, declined, expired
            $table->date('valid_until')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_quotes');
    }
};