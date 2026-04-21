<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $todaySales = (float) Sale::whereDate('created_at', today())->sum('total');
        $todayOrders = (int) Sale::whereDate('created_at', today())->count();
        $lowStockCount = (int) Product::where('stock', '>', 0)
            ->whereColumn('stock', '<=', 'reorder_level')
            ->count();
        $outOfStock = (int) Product::where('stock', 0)->count();

        $start = Carbon::now()->subDays(6)->startOfDay();
        $end = Carbon::now()->endOfDay();

        $dailyTotals = Sale::query()
            ->selectRaw('DATE(created_at) as d, SUM(total) as sales')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('d')
            ->pluck('sales', 'd');

        $weeklySales = collect(range(0, 6))->map(function (int $i) use ($start, $dailyTotals) {
            $date = $start->copy()->addDays($i);
            $key = $date->toDateString();
            return [
                'day' => $date->format('D'),
                'sales' => (int) round((float) ($dailyTotals[$key] ?? 0)),
            ];
        })->values();

        $recentSales = Sale::with('items.product')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn ($sale) => [
                'id' => $sale->receipt_number,
                'customer' => $sale->customer_name ?? 'Walk-in Customer',
                'amount' => 'KSh ' . number_format($sale->total, 0),
                'status' => 'completed',
                'method' => ucfirst($sale->payment_method),
                'time' => $sale->created_at->format('g:i A'),
            ]);

        $lowStock = Product::where('stock', '>', 0)
            ->whereColumn('stock', '<=', 'reorder_level')
            ->orderBy('stock')
            ->take(5)
            ->get()
            ->map(fn ($p) => [
                'product' => $p->name,
                'stock' => $p->stock,
                'reorder' => $p->reorder_level,
            ]);

        return $this->success([
            'stats' => [
                ['label' => "Today's Sales", 'value' => 'KSh ' . number_format($todaySales, 0), 'trend' => '+0%', 'up' => true],
                ['label' => 'Total Orders', 'value' => (string) $todayOrders, 'trend' => '+0%', 'up' => true],
                ['label' => 'Low Stock Alerts', 'value' => (string) $lowStockCount, 'trend' => '', 'up' => false],
                ['label' => 'Out of Stock', 'value' => (string) $outOfStock, 'trend' => '', 'up' => false],
            ],
            'weekly_sales' => $weeklySales,
            'recent_sales' => $recentSales,
            'low_stock_alerts' => $lowStock,
        ]);
    }
}

