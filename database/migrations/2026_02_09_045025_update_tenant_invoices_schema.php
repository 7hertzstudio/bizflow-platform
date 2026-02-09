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
        Schema::table('tenant_invoices', function (Blueprint $table) {
            $table->foreignUlid('brand_id')->after('id')->nullable()->constrained('brands')->onDelete('cascade');
            
            // Polymorphic source tracking
            $table->ulid('reference_id')->nullable()->after('invoice_number');
            $table->string('reference_type')->nullable()->after('reference_id');
            
            $table->bigInteger('amount_paid')->default(0)->after('total');
            
            // Date handling
            $table->date('issue_date')->nullable()->after('status');
            $table->string('pdf_path')->nullable()->after('paid_at');
            
            // Remove old decimal columns
            $table->dropColumn(['rounding_adjustment', 'exchange_rate']);
        });

        // Separate closure for type changes to avoid column existence issues during complex alters
        Schema::table('tenant_invoices', function (Blueprint $table) {
            $table->bigInteger('subtotal')->default(0)->change();
            $table->bigInteger('discount_total')->default(0)->change();
            $table->bigInteger('tax_total')->default(0)->change();
            $table->bigInteger('total')->default(0)->change();
        });

        Schema::table('tenant_invoice_items', function (Blueprint $table) {
             // Rename FK
            $table->dropForeign('tenant_invoice_items_tenant_plan_id_foreign');
            $table->renameColumn('tenant_plan_id', 'product_plan_id');
            
            $table->renameColumn('row_total', 'total_price');

            // Remove complex discount logic columns
            $table->dropColumn(['use_master_discount', 'custom_discount_type', 'custom_discount_value']);
            
            $table->integer('quantity')->default(1)->after('description');
            $table->dropColumn(['qty']);
        });

        Schema::table('tenant_invoice_items', function (Blueprint $table) {
            $table->bigInteger('unit_price')->default(0)->change();
            $table->bigInteger('total_price')->default(0)->change();
        });

        Schema::table('tenant_invoice_items', function (Blueprint $table) {
            $table->foreign('product_plan_id')->references('id')->on('product_plans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_invoice_items', function (Blueprint $table) {
            $table->dropForeign(['product_plan_id']);
            $table->renameColumn('product_plan_id', 'tenant_plan_id');
            $table->renameColumn('total_price', 'row_total');
            $table->integer('qty')->default(1);
            $table->dropColumn(['quantity']);
        });

         Schema::table('tenant_invoices', function (Blueprint $table) {
            $table->dropColumn(['brand_id', 'reference_id', 'reference_type', 'amount_paid', 'issue_date', 'pdf_path']);
        });
    }
};
