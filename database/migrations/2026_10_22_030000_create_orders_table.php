<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table): void {
                $table->id();
                $table->string('order_number')->unique();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone')->nullable();
                $table->text('shipping_address')->nullable();
                $table->decimal('total_amount', 10, 2);
                $table->string('payment_method')->default('aba_pay');
                $table->string('payment_status')->default('paid');
                $table->string('order_status')->default('processing');
                $table->json('items')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
