<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class POSController extends Controller
{
    public function products()
    {
        return response()->json([
            'data' => [],
        ]);
    }

    public function recordSale(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'total' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,mpesa,card'],
            'customer_name' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        return response()->json([
            'message' => 'Sale recorded (demo mode)',
            'receipt_number' => 'R-' . Str::upper(Str::random(8)),
            'total' => $data['total'],
            'payment_method' => $data['payment_method'],
        ]);
    }
}

