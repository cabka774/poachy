<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id', 'receipt_number', 'subtotal', 'tax', 'total',
        'payment_method', 'customer_name', 'customer_phone',
    ];

    /** A sale belongs to the user (cashier) who processed it */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** A sale has many line items */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}

