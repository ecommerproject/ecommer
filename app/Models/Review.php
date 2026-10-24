<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'customer_name',
        'customer_email',
        'rating',
        'review_title',
        'review_body',
        'status',
        'is_verified_buyer',
        'admin_reply',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_verified_buyer' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
