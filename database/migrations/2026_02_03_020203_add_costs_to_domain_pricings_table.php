<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('domain_pricings', function (Blueprint $table) {
            $table->decimal('register_cost', 10, 2)->default(0)->after('register_price');
            $table->decimal('renew_cost', 10, 2)->default(0)->after('renew_price');
            $table->decimal('transfer_cost', 10, 2)->default(0)->after('transfer_price');
        });
    }

    public function down(): void
    {
        Schema::table('domain_pricings', function (Blueprint $table) {
            $table->dropColumn(['register_cost', 'renew_cost', 'transfer_cost']);
        });
    }
};