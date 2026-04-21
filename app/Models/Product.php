<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sku', 'category', 'image', 'price', 'stock', 'reorder_level',
    ];

    protected $appends = ['status'];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'reorder_level' => 'integer',
    ];

    public function getStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'Out of Stock';
        }

        if ($this->stock <= $this->reorder_level) {
            return 'Low Stock';
        }

        return 'In Stock';
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}

