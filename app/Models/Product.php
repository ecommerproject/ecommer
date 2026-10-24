<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name_km',
        'name_en',
        'category',
        'price',
        'old_price',
        'rating',
        'image_url',
        'badge',
        'is_active',
        'is_new',
        'sort_order',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'rating' => 'decimal:1',
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'stock' => 'integer',
        ];
    }

    public function getStockStatusAttribute(): string
    {
        $currentStock = $this->stock ?? 45;
        if ($currentStock <= 0) {
            return 'out_of_stock';
        }
        if ($currentStock <= 10) {
            return 'low_stock';
        }

        return 'in_stock';
    }

    public function getSkuAttribute(): string
    {
        $prefix = strtoupper(substr($this->category ?? 'PR', 0, 2));

        return 'DM-'.$prefix.'-'.str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function toCatalogArray(string $locale, int $order): array
    {
        $name = $locale === 'en' ? $this->name_en : $this->name_km;
        $categoryName = __('store.products_data.'.$this->category, [], $locale);
        $badge = $this->badge;

        if ($badge !== null && ! str_starts_with($badge, '-')) {
            $translatedBadge = __('store.products_data.'.$badge, [], $locale);
            $badge = $translatedBadge === 'store.products_data.'.$badge ? $badge : $translatedBadge;
        }

        return [
            'id' => (string) $this->id,
            'order' => $order,
            'price' => (float) $this->price,
            'old_price' => $this->old_price === null ? null : (float) $this->old_price,
            'rating' => (float) $this->rating,
            'image' => $this->image_url,
            'badge' => $badge,
            'name' => $name,
            'category' => $categoryName,
            'filter_key' => $this->category,
            'is_new' => $this->is_new,
        ];
    }
}
