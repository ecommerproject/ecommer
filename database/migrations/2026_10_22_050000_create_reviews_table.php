<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->unsignedTinyInteger('rating')->default(5);
                $table->string('review_title')->nullable();
                $table->text('review_body');
                $table->string('status')->default('approved'); // approved, pending, rejected
                $table->boolean('is_verified_buyer')->default(true);
                $table->text('admin_reply')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
