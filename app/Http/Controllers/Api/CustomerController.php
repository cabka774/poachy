<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $customers = Customer::where('user_id', $request->user()->id)
            ->withCount('sales')
            ->withSum('sales as total_spent', 'total')
            ->withMax('sales as last_visit', 'created_at')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'phone' => $c->phone,
                'email' => $c->email,
                'location' => $c->location,
                'purchase_count' => (int) ($c->sales_count ?? 0),
                'total_spent' => 'KSh ' . number_format((float) ($c->total_spent ?? 0), 0),
                'last_visit' => $c->last_visit,
                'joined' => $c->created_at?->format('d M Y'),
            ]);

        return response()->json(['data' => $customers, 'total' => $customers->count()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $customer = Customer::create(array_merge($validated, ['user_id' => $request->user()->id]));
        return response()->json(['data' => $customer, 'message' => 'Customer added'], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $customer = Customer::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        $customer->update($request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'email' => 'sometimes|nullable|email|max:255',
            'location' => 'sometimes|nullable|string|max:255',
        ]));

        return response()->json(['data' => $customer, 'message' => 'Customer updated']);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        Customer::where('id', $id)->where('user_id', $request->user()->id)->delete();
        return response()->json(['message' => 'Customer deleted']);
    }
}

