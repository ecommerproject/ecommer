<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('name_km');
            $table->string('name_en');
            $table->string('category', 40)->index();
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('rating', 2, 1)->default(5);
            $table->string('image_url', 2048);
            $table->string('badge')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_new')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });

        $featuredCount = (int) config('store.featured_products_count', 4);
        $rows = [];

        foreach (config('store.products', []) as $index => $product) {
            $image = $product['image'];
            $rows[] = [
                'name_km' => Lang::get('store.products_data.'.$product['name'], [], 'km'),
                'name_en' => Lang::get('store.products_data.'.$product['name'], [], 'en'),
                'category' => $product['category'],
                'price' => $product['price'],
                'old_price' => $product['old_price'],
                'rating' => $product['rating'],
                'image_url' => 'https://images.unsplash.com/'.$image.'?auto=format&fit=crop&w=640&q=85',
                'badge' => $product['badge'],
                'is_active' => true,
                'is_new' => $index >= $featuredCount,
                'sort_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($rows !== []) {
            DB::table('products')->insert($rows);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
