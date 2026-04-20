<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_phone',
        'business_email',
        'business_location',
        'currency',
        'tax_rate',
        'receipt_footer',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

