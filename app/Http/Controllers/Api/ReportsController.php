<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function index()
    {
        return response()->json([
            'weekly_revenue' => [
                ['day' => 'Mon', 'amount' => 0],
                ['day' => 'Tue', 'amount' => 0],
                ['day' => 'Wed', 'amount' => 0],
                ['day' => 'Thu', 'amount' => 0],
                ['day' => 'Fri', 'amount' => 0],
                ['day' => 'Sat', 'amount' => 0],
                ['day' => 'Sun', 'amount' => 0],
            ],
            'sales_by_category' => [],
            'summary' => [
                'total_revenue' => 'KSh 0',
                'total_sales' => 0,
                'avg_sale_value' => 'KSh 0',
                'top_product' => '—',
            ],
        ]);
    }
}

