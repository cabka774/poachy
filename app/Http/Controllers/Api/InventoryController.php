<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $products = Product::orderBy('name')->get();
        return $this->success($products, null, 200, ['total' => $products->count()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|max:50|unique:products',
            'category'      => 'required|string|max:100',
            'image'         => 'nullable|string|max:10',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
        ]);

        $product = Product::create($validated);
        return $this->created($product, 'Product added successfully');
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'sometimes|string|max:255',
            'category'      => 'sometimes|string|max:100',
            'image'         => 'sometimes|string|max:10',
            'price'         => 'sometimes|numeric|min:0',
            'stock'         => 'sometimes|integer|min:0',
            'reorder_level' => 'sometimes|integer|min:0',
        ]);

        $product->update($validated);
        return $this->success($product, 'Product updated successfully');
    }

    public function destroy(int $id): JsonResponse
    {
        Product::findOrFail($id)->delete();
        return $this->success(null, 'Product deleted successfully');
    }
}

