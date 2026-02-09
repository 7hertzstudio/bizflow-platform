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
        Schema::table('tenant_domains', function (Blueprint $table) {
            $table->foreignUlid('brand_id')->after('id')->nullable()->constrained('brands')->onDelete('cascade');
            $table->renameColumn('domain', 'domain_name');
            $table->renameColumn('is_managed', 'is_managed_by_us');
            $table->renameColumn('registered_at', 'registration_date');
            $table->renameColumn('expires_at', 'expiry_date');
            
            $table->date('next_renewal_date')->nullable()->after('expiry_date');
            $table->string('cloudflare_zone_id')->nullable()->after('dns_settings');
            $table->timestamp('last_dns_check_at')->nullable()->after('auto_renew');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_domains', function (Blueprint $table) {
            $table->dropColumn(['brand_id', 'next_renewal_date', 'cloudflare_zone_id', 'last_dns_check_at']);
            $table->renameColumn('domain_name', 'domain');
            $table->renameColumn('is_managed_by_us', 'is_managed');
            $table->renameColumn('registration_date', 'registered_at');
            $table->renameColumn('expiry_date', 'expires_at');
        });
    }
};
