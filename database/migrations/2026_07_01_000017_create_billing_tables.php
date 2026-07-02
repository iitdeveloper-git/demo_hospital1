<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop existing bills table to prevent conflict
        Schema::dropIfExists('bills');

        Schema::create('hospital_packages', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::create('insurance_companies', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_headers', function (Blueprint $table): void {
            $table->id();
            $table->string('invoice_number')->unique()->index();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->string('status')->default('pending')->index(); // paid, pending, partially-paid, cancelled
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('invoice_header_id')->constrained('invoice_headers')->cascadeOnDelete();
            $table->string('item_name')->index();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('invoice_header_id')->constrained('invoice_headers')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->index(); // cash, card, upi, insurance, wallet
            $table->string('transaction_reference')->nullable()->index();
            $table->string('status')->default('completed')->index();
            $table->timestamps();
        });

        Schema::create('refunds', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->text('reason')->nullable();
            $table->string('status')->default('pending')->index(); // pending, approved, rejected
            $table->timestamps();
        });

        Schema::create('insurance_claims', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('invoice_header_id')->constrained('invoice_headers')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('insurance_companies')->cascadeOnDelete();
            $table->string('policy_number')->index();
            $table->decimal('claim_amount', 12, 2);
            $table->decimal('approved_amount', 12, 2)->default(0);
            $table->string('status')->default('pending')->index(); // pending, approved, rejected
            $table->timestamps();
        });

        Schema::create('ledger_accounts', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique()->index();
            $table->string('name')->index();
            $table->string('type')->index(); // income, expense, asset, liability
            $table->timestamps();
        });

        Schema::create('journal_entries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('ledger_account_id')->constrained('ledger_accounts')->cascadeOnDelete();
            $table->decimal('debit_amount', 12, 2)->default(0);
            $table->decimal('credit_amount', 12, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('patient_wallets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->decimal('balance', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_wallets');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('ledger_accounts');
        Schema::dropIfExists('insurance_claims');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoice_headers');
        Schema::dropIfExists('insurance_companies');
        Schema::dropIfExists('hospital_packages');
    }
};
