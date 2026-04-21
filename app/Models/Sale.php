<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'customer_id', 'receipt_number', 'subtotal', 'tax', 'total',
        'payment_method', 'customer_name', 'customer_phone',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'user_id' => 'integer',
        'customer_id' => 'integer',
    ];

    /** A sale belongs to the user (cashier) who processed it */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /** A sale has many line items */
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}

