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
        Schema::create('tenant_scheduled_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            $table->string('report_type')->default('website_health');
            $table->string('frequency')->default('weekly');
            $table->string('title');
            $table->text('content_summary')->nullable();
            $table->string('report_file_path')->nullable();
            $table->json('recipients');
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('next_run_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_scheduled_reports');
    }
};