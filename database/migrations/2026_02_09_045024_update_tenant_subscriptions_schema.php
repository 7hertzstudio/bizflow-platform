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
        Schema::table('tenant_subscriptions', function (Blueprint $table) {
            // Rename FK
            $table->dropForeign(['tenant_plan_id']);
            $table->renameColumn('tenant_plan_id', 'product_plan_id');
            
            // Add new fields
            $table->boolean('is_bundle')->default(false)->after('product_plan_id');
            $table->string('custom_name')->nullable()->after('is_bundle');
            $table->text('notes')->nullable()->after('custom_name');
            $table->string('billing_interval')->default('monthly')->after('notes'); // monthly, yearly
            
            // Renames and type changes
            $table->renameColumn('price_at_subscription', 'total_amount');
            $table->renameColumn('currency_at_subscription', 'currency');
            
            // New renewal field
            $table->timestamp('next_renewal_at')->nullable()->after('ends_at');
        });

        Schema::table('tenant_subscriptions', function (Blueprint $table) {
            $table->foreign('product_plan_id')->references('id')->on('product_plans')->onDelete('cascade');
            $table->bigInteger('total_amount')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['product_plan_id']);
            $table->renameColumn('product_plan_id', 'tenant_plan_id');
            
            $table->dropColumn(['is_bundle', 'custom_name', 'notes', 'billing_interval', 'next_renewal_at']);
            
            $table->renameColumn('total_amount', 'price_at_subscription');
            $table->renameColumn('currency', 'currency_at_subscription');
        });

        Schema::table('tenant_subscriptions', function (Blueprint $table) {
            $table->foreign('tenant_plan_id')->references('id')->on('tenant_plans')->onDelete('cascade');
            $table->decimal('price_at_subscription', 15, 2)->change();
        });
    }
};