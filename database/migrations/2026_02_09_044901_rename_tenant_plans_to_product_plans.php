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
        Schema::rename('tenant_plans', 'product_plans');

        Schema::table('product_plans', function (Blueprint $table) {
            // Remove old FK using the original constraint name since we just renamed the table
            $table->dropForeign('tenant_plans_brand_id_foreign');
            $table->dropColumn(['brand_id', 'category']);

            // Add new FK to Product
            $table->foreignUlid('product_id')->after('id')->constrained('products')->onDelete('cascade');

            // Renames and type changes
            $table->renameColumn('base_price', 'price_monthly');
            $table->renameColumn('base_currency', 'currency');
            
            $table->bigInteger('price_yearly')->default(0);
        });

        // Separate closure for type changes and remaining additions
        Schema::table('product_plans', function (Blueprint $table) {
            $table->bigInteger('price_monthly')->default(0)->change();
            
            // Add Compare At prices
            $table->bigInteger('compare_at_price_monthly')->nullable()->after('price_monthly');
            $table->bigInteger('compare_at_price_yearly')->nullable()->after('price_yearly');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_plans', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'price_yearly', 'compare_at_price_monthly', 'compare_at_price_yearly']);
            
            $table->renameColumn('price_monthly', 'base_price');
            $table->renameColumn('currency', 'base_currency');
            
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('category')->after('name');
        });

        Schema::rename('product_plans', 'tenant_plans');
    }
};