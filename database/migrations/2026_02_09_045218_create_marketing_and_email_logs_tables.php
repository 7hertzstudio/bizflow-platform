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
        Schema::create('marketing_subscribers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('plunk_id')->nullable();
            $table->string('email');
            $table->string('status')->default('pending'); // pending, active, unsubscribed, bounced
            $table->json('tags')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('marketing_campaigns', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->string('subject');
            $table->text('content');
            $table->json('segment_tags')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->string('status')->default('draft');
            $table->json('stats')->nullable();
            $table->timestamps();
        });

        Schema::create('email_logs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('provider')->default('smtp'); // smtp, plunk
            $table->string('recipient_email');
            $table->string('message_id')->nullable();
            $table->string('status')->default('sent');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
        Schema::dropIfExists('marketing_campaigns');
        Schema::dropIfExists('marketing_subscribers');
    }
};