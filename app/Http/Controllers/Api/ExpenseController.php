<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $expenses = Expense::where('user_id', $request->user()->id)
            ->orderByDesc('date')
            ->get();

        $totalThisMonth = Expense::where('user_id', $request->user()->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $byCategory = Expense::where('user_id', $request->user()->id)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'data' => $expenses,
            'total_this_month' => number_format((float) $totalThisMonth, 0),
            'by_category' => $byCategory,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $expense = Expense::create(array_merge($validated, ['user_id' => $request->user()->id]));
        return response()->json(['data' => $expense, 'message' => 'Expense recorded'], 201);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        Expense::where('id', $id)->where('user_id', $request->user()->id)->delete();
        return response()->json(['message' => 'Expense deleted']);
    }
}

