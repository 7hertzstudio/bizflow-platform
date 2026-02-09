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
        Schema::table('tenant_businesses', function (Blueprint $table) {
            if (!Schema::hasColumn('tenant_businesses', 'brand_id')) {
                $table->foreignUlid('brand_id')->after('id')->nullable()->constrained('brands')->onDelete('cascade');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'brand_id')) {
                $table->foreignUlid('brand_id')->after('id')->nullable()->constrained('brands')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['brand_id']);
        });

        Schema::table('tenant_businesses', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['brand_id']);
        });
    }
};