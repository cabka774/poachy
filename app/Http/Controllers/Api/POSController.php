<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class POSController extends Controller
{
    use ApiResponse;

    public function products(): JsonResponse
    {
        $products = Product::query()
            ->orderBy('name')
            ->get()
            ->map(fn (Product $p) => [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
                'category' => $p->category,
                'emoji' => $p->image,
                'stock' => (int) $p->stock,
            ]);

        return $this->success($products);
    }

    public function recordSale(Request $request): JsonResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'in:cash,mpesa,card'],
            'customer_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'customer_phone' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        $userId = (int) $request->user()->id;

        $result = DB::transaction(function () use ($data, $userId) {
            do {
                $receiptNumber = 'R-' . Str::upper(Str::random(8));
            } while (Sale::where('receipt_number', $receiptNumber)->exists());

            $sale = Sale::create([
                'user_id' => $userId,
                'receipt_number' => $receiptNumber,
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
                'payment_method' => $data['payment_method'],
                'customer_name' => $data['customer_name'] ?? null,
                'customer_phone' => $data['customer_phone'] ?? null,
            ]);

            $subtotal = 0.0;

            $requestedQtyByProductId = collect($data['items'])
                ->groupBy('product_id')
                ->map(fn ($rows) => (int) collect($rows)->sum('quantity'));

            foreach ($requestedQtyByProductId as $productId => $qty) {
                /** @var Product $product */
                $product = Product::whereKey((int) $productId)->lockForUpdate()->firstOrFail();

                if ($product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => ["Insufficient stock for {$product->name}. Available: {$product->stock}, requested: {$qty}."],
                    ]);
                }

                $unitPrice = (float) $product->price;
                $lineSubtotal = $unitPrice * $qty;
                $subtotal += $lineSubtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $lineSubtotal,
                ]);

                $product->decrement('stock', $qty);
            }

            $sale->update([
                'subtotal' => $subtotal,
                'tax' => 0,
                'total' => $subtotal,
            ]);

            return [
                'sale' => $sale->load(['items.product', 'user']),
            ];
        });

        /** @var Sale $sale */
        $sale = $result['sale'];

        return $this->created([
            'receipt_number' => $sale->receipt_number,
            'total' => (float) $sale->total,
            'payment_method' => $sale->payment_method,
        ], 'Sale recorded successfully');
    }
}

