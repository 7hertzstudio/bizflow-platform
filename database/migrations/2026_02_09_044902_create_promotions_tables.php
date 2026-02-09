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
        Schema::create('promotions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->string('discount_type')->default('percentage'); // percentage, fixed_amount
            $table->integer('discount_value'); // e.g., 15 for 15%
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('product_plan_promotion', function (Blueprint $table) {
            $table->foreignUlid('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->foreignUlid('product_plan_id')->constrained('product_plans')->onDelete('cascade');
            $table->primary(['promotion_id', 'product_plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_plan_promotion');
        Schema::dropIfExists('promotions');
    }
};