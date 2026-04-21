<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PoachyController extends Controller
{
    public function dashboard(): View
    {
        return view('poachy.dashboard', ['activePage' => 'dashboard']);
    }

    public function pos(): View
    {
        return view('poachy.pos', ['activePage' => 'pos']);
    }

    public function inventory(): View
    {
        return view('poachy.inventory', ['activePage' => 'inventory']);
    }

    public function reports(): View
    {
        return view('poachy.reports', ['activePage' => 'reports']);
    }

    public function expenses(): View
    {
        return view('poachy.placeholder', [
            'activePage' => 'expenses',
            'title' => 'Expense Management',
            'description' => 'Track and manage your business expenses, view spending patterns, and control costs effectively.',
        ]);
    }

    public function ecommerce(): View
    {
        return view('poachy.placeholder', [
            'activePage' => 'ecommerce',
            'title' => 'Ecommerce Marketplace',
            'description' => 'Sell your products online, manage orders, and reach more customers across East Africa.',
        ]);
    }

    public function customers(): View
    {
        return view('poachy.placeholder', [
            'activePage' => 'customers',
            'title' => 'Customer Management',
            'description' => 'Keep track of your customers, view purchase history, and build lasting relationships.',
        ]);
    }

    public function settings(): View
    {
        return view('poachy.placeholder', [
            'activePage' => 'settings',
            'title' => 'Settings',
            'description' => 'Configure your business preferences, manage users, and customize Poachy to your needs.',
        ]);
    }
}
