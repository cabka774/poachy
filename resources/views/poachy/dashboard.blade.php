@extends('layouts.poachy')

@section('content')
<section class="page">
    <h1>Dashboard</h1>
    <p class="lead">Welcome back! Here's what's happening with your business today.</p>
    <div class="stats">
        <article class="card"><div style="display:flex;"><strong>Today's Sales</strong><span class="trend" style="color:var(--success)">+12%</span></div><div class="stat-value">KSh 88,450</div></article>
        <article class="card"><div style="display:flex;"><strong>Total Orders</strong><span class="trend" style="color:var(--success)">+8%</span></div><div class="stat-value">156</div></article>
        <article class="card"><div style="display:flex;"><strong>Expenses Today</strong><span class="trend" style="color:var(--danger)">-3%</span></div><div class="stat-value">KSh 12,300</div></article>
        <article class="card"><div style="display:flex;"><strong>Low Stock Alerts</strong><span class="trend" style="color:#92400e">Action Needed</span></div><div class="stat-value">4</div></article>
    </div>
    <div class="dashboard-grid">
        <article class="card"><strong>Sales Overview</strong><div class="stat-title">Last 7 days performance</div><div class="chart"><div class="line"></div></div></article>
        <article class="card"><strong>Low Stock Alerts</strong><div class="stat-title">Items running low</div><div class="alerts">
            <div class="alert-row"><strong>Cooking Oil 1L</strong><div style="color:#92400e;">3 bottles remaining</div></div>
            <div class="alert-row"><strong>Sugar 1kg</strong><div style="color:#92400e;">5 packets remaining</div></div>
            <div class="alert-row"><strong>Rice 2kg</strong><div style="color:#92400e;">8 bags remaining</div></div>
            <div class="alert-row"><strong>Laundry Soap</strong><div style="color:#92400e;">4 bars remaining</div></div>
        </div></article>
    </div>
    <article class="card table-wrap">
        <strong>Recent Transactions</strong>
        <table>
            <thead><tr><th>Time</th><th>Product</th><th>Amount</th><th>Payment</th><th>Status</th></tr></thead>
            <tbody>
                <tr><td>10:45 AM</td><td>Rice 2kg</td><td>KSh 450</td><td>Mpesa</td><td><span class="badge ok">completed</span></td></tr>
                <tr><td>10:32 AM</td><td>Cooking Oil 1L</td><td>KSh 280</td><td>Cash</td><td><span class="badge ok">completed</span></td></tr>
                <tr><td>10:18 AM</td><td>Bread (4 loaves)</td><td>KSh 200</td><td>Card</td><td><span class="badge ok">completed</span></td></tr>
                <tr><td>09:55 AM</td><td>Sugar 1kg</td><td>KSh 150</td><td>Mpesa</td><td><span class="badge ok">completed</span></td></tr>
                <tr><td>09:42 AM</td><td>Milk 500ml</td><td>KSh 210</td><td>Cash</td><td><span class="badge ok">completed</span></td></tr>
                <tr><td>09:28 AM</td><td>Eggs (tray)</td><td>KSh 450</td><td>Mpesa</td><td><span class="badge warn">pending</span></td></tr>
            </tbody>
        </table>
    </article>
</section>
@endsection
