<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [],
            'total' => 0,
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        return response()->json([
            'message' => 'Created (demo mode)',
            'data' => array_merge(['id' => 1, 'status' => 'In Stock'], $payload),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $updates = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'sku' => ['sometimes', 'nullable', 'string', 'max:255'],
            'category' => ['sometimes', 'nullable', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
        ]);

        return response()->json([
            'message' => 'Updated (demo mode)',
            'id' => (int) $id,
            'updates' => $updates,
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => 'Deleted (demo mode)',
            'id' => (int) $id,
        ]);
    }
}

