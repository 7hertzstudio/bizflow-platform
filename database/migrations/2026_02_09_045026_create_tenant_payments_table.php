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
        Schema::create('tenant_payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            $table->foreignUlid('tenant_invoice_id')->constrained('tenant_invoices')->onDelete('cascade');
            $table->foreignUlid('brand_payment_method_id')->nullable()->constrained('brand_payment_methods')->onDelete('set null');
            
            $table->bigInteger('amount'); // Cents
            $table->string('currency');
            $table->timestamp('payment_date');
            $table->string('transaction_reference')->nullable();
            $table->string('status')->default('completed'); // pending, completed, failed, refunded
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_payments');
    }
};