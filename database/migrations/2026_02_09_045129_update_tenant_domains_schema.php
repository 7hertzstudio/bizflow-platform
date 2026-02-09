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
            $table->boolean('is_managed_by_us')->default(false)->after('domain');
            $table->date('registration_date')->nullable()->after('is_verified');
            $table->date('expiry_date')->nullable()->after('registration_date');
            $table->date('next_renewal_date')->nullable()->after('expiry_date');
            $table->string('cloudflare_zone_id')->nullable()->after('dns_settings');
            $table->boolean('auto_renew')->default(true)->after('cloudflare_zone_id');
            $table->timestamp('last_dns_check_at')->nullable()->after('auto_renew');
            $table->text('notes')->nullable()->after('last_dns_check_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_domains', function (Blueprint $table) {
            $table->dropColumn(['brand_id', 'is_managed_by_us', 'registration_date', 'expiry_date', 'next_renewal_date', 'cloudflare_zone_id', 'auto_renew', 'last_dns_check_at', 'notes']);
            $table->renameColumn('domain_name', 'domain');
        });
    }
};