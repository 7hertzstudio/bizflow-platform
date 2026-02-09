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
        // Brand Settings
        Schema::create('brand_settings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('group')->default('general'); // invoice, email, theme
            $table->string('key'); // primary_color
            $table->text('value')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        // Brand Contacts
        Schema::create('brand_contacts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('type')->default('email'); // email, phone, whatsapp, telegram
            $table->string('value');
            $table->string('label')->default('Support');
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        // Brand Socials
        Schema::create('brand_socials', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('platform'); // facebook, linkedin
            $table->string('url');
            $table->string('label')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Brand Payment Methods
        Schema::create('brand_payment_methods', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('type')->default('bank_transfer'); // bank_transfer, online_payment
            $table->string('label'); // Main Business Account
            $table->json('details'); // IBAN, Swift, etc.
            $table->string('currency')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Remove old JSON column from brands if it exists
        if (Schema::hasColumn('brands', 'bank_details')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->dropColumn(['bank_details']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('brands')) {
             Schema::table('brands', function (Blueprint $table) {
                $table->json('bank_details')->nullable();
            });
        }

        Schema::dropIfExists('brand_payment_methods');
        Schema::dropIfExists('brand_socials');
        Schema::dropIfExists('brand_contacts');
        Schema::dropIfExists('brand_settings');
    }
};