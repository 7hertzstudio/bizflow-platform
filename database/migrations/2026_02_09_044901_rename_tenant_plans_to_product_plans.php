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
            // Remove old FK and category string
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['brand_id', 'category']);

            // Add new FK to Product
            $table->foreignUlid('product_id')->after('id')->constrained('products')->onDelete('cascade');

            // Renames and type changes
            $table->renameColumn('base_price', 'price_monthly');
            $table->renameColumn('base_currency', 'currency');
            
            // Add new columns
            $table->bigInteger('price_yearly')->default(0)->after('base_price'); // base_price is now price_monthly in the db after rename? No, rename happens in the same batch or different? Usually safe to use old name for positioning if same closure? Actually better to just add them.
        });

        // Separate closure for type changes to avoid issues with rename in some drivers
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
