<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domain_pricings', function (Blueprint $table) {
            $table->id();
            $table->string('tld')->unique(); // .com, .pk
            $table->decimal('register_price', 10, 2);
            $table->decimal('renew_price', 10, 2);
            $table->decimal('transfer_price', 10, 2);
            $table->string('currency')->default('USD');
            $table->integer('min_years')->default(1);
            $table->integer('max_years')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domain_pricings');
    }
};