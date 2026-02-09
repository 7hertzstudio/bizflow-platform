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
        // Tenant Quotes
        Schema::create('tenant_quotes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignUlid('tenant_business_id')->nullable()->constrained('tenant_businesses')->onDelete('cascade');
            $table->ulid('lead_id')->nullable(); // Will link to leads table later
            
            $table->string('title');
            $table->string('reference_number')->unique();
            $table->text('introduction')->nullable();
            $table->text('terms_and_conditions')->nullable();
            
            $table->bigInteger('subtotal');
            $table->bigInteger('tax_total')->default(0);
            $table->bigInteger('total');
            
            $table->string('status')->default('draft'); // draft, sent, accepted, rejected, expired
            $table->date('valid_until')->nullable();
            $table->timestamps();
        });

        // Tenant Contracts
        Schema::create('tenant_contracts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            $table->foreignUlid('tenant_quote_id')->nullable()->constrained('tenant_quotes')->onDelete('set null');
            
            $table->string('title');
            $table->text('content'); // Final Markdown
            $table->string('status')->default('draft'); // draft, sent, signed, terminated
            
            $table->timestamp('signed_at')->nullable();
            $table->string('signer_ip')->nullable();
            $table->string('signer_name')->nullable();
            $table->string('pdf_path')->nullable();
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        // Tenant Projects
        Schema::create('tenant_projects', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_business_id')->constrained('tenant_businesses')->onDelete('cascade');
            $table->foreignUlid('tenant_contract_id')->nullable()->constrained('tenant_contracts')->onDelete('set null');
            $table->foreignUlid('manager_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('planning'); // planning, in_progress, on_hold, completed, canceled
            $table->string('priority')->default('medium'); // low, medium, high, urgent
            
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->bigInteger('budget')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_projects');
        Schema::dropIfExists('tenant_contracts');
        Schema::dropIfExists('tenant_quotes');
    }
};