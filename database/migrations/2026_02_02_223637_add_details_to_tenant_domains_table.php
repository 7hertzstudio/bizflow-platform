<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenant_domains', function (Blueprint $table) {
            $table->string('registrar')->nullable()->after('domain'); // Namecheap, Cloudflare
            $table->boolean('is_managed')->default(false)->after('registrar'); // Do we pay for it?
            $table->boolean('auto_renew')->default(true)->after('is_managed');
            
            $table->decimal('cost_price', 15, 2)->default(0)->after('auto_renew'); // What we pay
            $table->decimal('sell_price', 15, 2)->default(0)->after('cost_price'); // What we charge
            $table->string('currency')->default('USD')->after('sell_price');

            $table->date('registered_at')->nullable()->after('currency');
            $table->date('expires_at')->nullable()->after('registered_at');
            
            $table->string('status')->default('active')->after('expires_at'); // active, expired, transferring
            $table->text('notes')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('tenant_domains', function (Blueprint $table) {
            $table->dropColumn([
                'registrar', 'is_managed', 'auto_renew', 
                'cost_price', 'sell_price', 'currency', 
                'registered_at', 'expires_at', 'status', 'notes'
            ]);
        });
    }
};