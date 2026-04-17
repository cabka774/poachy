@extends('layouts.poachy')

@section('content')
<section class="page">
    <h1>Reports</h1>
    <p class="lead">Track performance, profitability, and category trends.</p>
    <div class="reports-tools">
        <input class="input" type="date">
        <input class="input" type="date">
        <button class="btn-alt">Export PDF</button>
        <button class="btn-alt">Export Excel</button>
    </div>
    <div class="stats">
        <article class="card"><strong>Total Revenue</strong><div class="stat-value">KSh 2,920,000</div></article>
        <article class="card"><strong>Total Sales</strong><div class="stat-value">6,430</div></article>
        <article class="card"><strong>Total Expenses</strong><div class="stat-value">KSh 1,140,000</div></article>
        <article class="card"><strong>Net Profit</strong><div class="stat-value">KSh 1,780,000</div></article>
    </div>
    <div class="reports-grid">
        <article class="card"><strong>Monthly Revenue</strong><div class="stat-title">Last 6 months</div><div class="bars"><span style="height:62%"></span><span style="height:70%"></span><span style="height:66%"></span><span style="height:82%"></span><span style="height:98%"></span><span style="height:88%"></span></div></article>
        <article class="card"><strong>Sales by Category</strong><div class="pie"></div><div class="stat-title">Grains 35% | Dairy 23% | Vegetables 15% | Others 27%</div></article>
    </div>
</section>
@endsection
