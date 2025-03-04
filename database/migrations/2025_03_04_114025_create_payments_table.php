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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->string('reference')->unique(); // Paystack transaction reference
            $table->decimal('amount', 10, 2); // Amount in NGN (e.g., 5000.00)
            $table->string('status')->default('pending'); // pending, success, failed
            $table->string('currency')->default('NGN');
            $table->timestamp('paid_at')->nullable();
            $table->json('paystack_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
