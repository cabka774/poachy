<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $start = Carbon::today()->subDays(6)->startOfDay();
        $end = Carbon::today()->endOfDay();

        $daily = Sale::selectRaw('DATE(created_at) as d, SUM(total) as amount')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('d')
            ->pluck('amount', 'd');

        $weeklyRevenue = collect(range(0, 6))->map(function (int $i) use ($start, $daily) {
            $date = $start->copy()->addDays($i);
            $key = $date->toDateString();
            return [
                'day' => $date->format('D'),
                'amount' => (float) ($daily[$key] ?? 0),
            ];
        })->values();

        $salesByCategory = SaleItem::query()
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.category', DB::raw('SUM(sale_items.subtotal) as amount'))
            ->groupBy('products.category')
            ->orderByDesc('amount')
            ->get()
            ->map(fn ($row) => [
                'category' => $row->category,
                'amount' => (float) $row->amount,
            ]);

        $totalRevenue = (float) Sale::sum('total');
        $totalSales = (int) Sale::count();
        $avgSaleValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0.0;

        $topProduct = SaleItem::query()
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as qty'))
            ->groupBy('products.name')
            ->orderByDesc('qty')
            ->first();

        return $this->success([
            'weekly_revenue' => $weeklyRevenue,
            'sales_by_category' => $salesByCategory,
            'summary' => [
                'total_revenue' => 'KSh ' . number_format($totalRevenue, 0),
                'total_sales' => $totalSales,
                'avg_sale_value' => 'KSh ' . number_format($avgSaleValue, 0),
                'top_product' => $topProduct?->name ?? '—',
            ],
        ]);
    }
}

