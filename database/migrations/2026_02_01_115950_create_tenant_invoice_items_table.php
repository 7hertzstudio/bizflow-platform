<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_invoice_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_invoice_id')->constrained('tenant_invoices')->onDelete('cascade');
            
            // Optional relation to a Plan (if standard)
            $table->foreignUlid('tenant_plan_id')->nullable()->constrained('tenant_plans')->onDelete('set null');
            
            // Item Details
            $table->string('description');
            $table->integer('qty')->default(1);
            $table->decimal('unit_price', 15, 2); // Base price before any logic
            
            // Discount Logic
            $table->boolean('use_master_discount')->default(true);
            $table->string('custom_discount_type')->nullable(); // percentage, fixed
            $table->decimal('custom_discount_value', 15, 2)->nullable();
            
            // Final Calculation Snapshot
            $table->decimal('row_total', 15, 2);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_invoice_items');
    }
};