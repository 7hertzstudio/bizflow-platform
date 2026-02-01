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
        Schema::create('tenant_plans', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->string('category'); // hosting, pos, development, bundle
            $table->decimal('base_price', 15, 2);
            $table->string('base_currency')->default('USD');
            $table->boolean('is_custom')->default(false);
            $table->json('features')->nullable();
            $table->string('status')->default('published'); // draft, published, archived
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_plans');
    }
};