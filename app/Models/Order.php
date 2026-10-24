<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'items',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'items' => 'array',
        ];
    }

    public function scopeProcessing(Builder $query): Builder
    {
        return $query->where('order_status', 'processing');
    }

    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('order_status', 'delivered');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('d M Y, h:i A');
    }

    public function getItemsCountAttribute(): int
    {
        if (! is_array($this->items)) {
            return 0;
        }

        return (int) array_sum(array_column($this->items, 'quantity'));
    }
}
