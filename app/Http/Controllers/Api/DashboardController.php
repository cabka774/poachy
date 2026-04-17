<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'stats' => [
                ['label' => 'Today Sales', 'value' => 'KSh 0', 'trend' => '0%', 'up' => true],
                ['label' => 'Orders', 'value' => '0', 'trend' => '0%', 'up' => true],
                ['label' => 'Customers', 'value' => '0', 'trend' => '0%', 'up' => true],
                ['label' => 'Low Stock', 'value' => '0', 'trend' => '0', 'up' => true],
            ],
            'recent_sales' => [],
            'low_stock_alerts' => [],
        ]);
    }
}

