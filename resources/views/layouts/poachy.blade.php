<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poachy - Business Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#16a34a; --primary-dark:#15803d; --bg:#f3f4f6; --text:#111827; --muted:#6b7280; --line:#e5e7eb; --success:#15803d; --danger:#dc2626; }
        * { box-sizing:border-box; } body { margin:0; font-family:"Inter",sans-serif; background:var(--bg); color:var(--text); }
        .shell{display:flex;min-height:100vh;} .sidebar{width:240px;background:var(--primary);color:#fff;display:flex;flex-direction:column;}
        .top{padding:1.5rem 1.2rem;border-bottom:1px solid rgba(255,255,255,.2);} .title{margin:0;font-size:1.75rem;font-weight:800;} .subtitle{margin:.15rem 0 0;font-size:.82rem;opacity:.9;}
        .menu{padding:.8rem;display:grid;gap:.3rem;} .menu a{color:#e8f7ec;text-decoration:none;border-radius:10px;padding:.66rem .72rem;font-size:.93rem;font-weight:500;} .menu a.active{background:#fff;color:var(--primary);font-weight:700;}
        .merchant{margin-top:auto;padding:.9rem;border-top:1px solid rgba(255,255,255,.2);display:flex;gap:.7rem;align-items:center;} .avatar{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.2);font-weight:700;}
        .main{flex:1;overflow:auto;} .topbar{height:72px;background:#fff;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;padding:0 1.2rem;gap:.8rem;}
        .search{max-width:420px;width:100%;border:1px solid var(--line);border-radius:10px;padding:.7rem .9rem;background:#f9fafb;} .top-actions{display:flex;gap:.8rem;align-items:center;}
        .chip{border:1px solid var(--line);background:#fff;border-radius:999px;padding:.55rem .8rem;font-weight:600;font-size:.82rem;} .user{width:36px;height:36px;border-radius:999px;background:var(--primary);color:#fff;display:grid;place-items:center;font-weight:700;}
        .content{padding:1.2rem;} .page h1{margin:0;font-size:2rem;} .lead{margin:.35rem 0 1rem;color:var(--muted);} .card{background:#fff;border:1px solid var(--line);border-radius:12px;padding:1rem;}
        .stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.8rem;margin-bottom:.9rem;} .stat-title{color:var(--muted);font-size:.84rem;margin-top:.3rem;} .stat-value{font-size:1.95rem;font-weight:700;margin-top:.2rem;} .trend{font-size:.76rem;font-weight:700;margin-left:auto;}
        .dashboard-grid,.pos-grid{display:grid;grid-template-columns:2fr 1fr;gap:.9rem;margin-bottom:.9rem;} .table-wrap{overflow:auto;}
        table{width:100%;border-collapse:collapse;font-size:.9rem;} th,td{text-align:left;padding:.75rem;border-bottom:1px solid var(--line);} tr:nth-child(even) td{background:#f9fafb;}
        .badge{display:inline-flex;padding:.2rem .55rem;border-radius:999px;font-size:.75rem;font-weight:700;} .ok{background:#dcfce7;color:var(--success);} .warn{background:#fef3c7;color:#92400e;} .bad{background:#fee2e2;color:var(--danger);}
        .chart{height:220px;border-radius:10px;border:1px dashed #d1d5db;position:relative;overflow:hidden;background:linear-gradient(to top,#fff,#fff),repeating-linear-gradient(to right,#eef2f7 0 1px,transparent 1px 16.6%),repeating-linear-gradient(to bottom,#eef2f7 0 1px,transparent 1px 20%);}
        .line{position:absolute;left:4%;right:4%;bottom:16%;height:56%;border-bottom:3px solid #16a34a;border-radius:100% 100% 0 0;transform:skewX(-18deg);}
        .alerts{display:grid;gap:.6rem;} .alert-row{padding:.7rem;border-radius:10px;border:1px solid #fde68a;background:#fffbeb;font-size:.88rem;}
        .products{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.65rem;} .product{border:1px solid var(--line);border-radius:12px;padding:.7rem;}
        .thumb{width:44px;height:44px;border-radius:9px;background:#ecfdf3;display:grid;place-items:center;color:var(--primary);font-weight:700;margin-bottom:.55rem;} .price{color:var(--primary);font-weight:700;}
        .payment{display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem;margin:.8rem 0;} .btn-alt{border:1px solid var(--line);border-radius:8px;padding:.6rem .4rem;background:#fff;font-weight:600;}
        .btn-primary{border:0;background:var(--primary);color:#fff;border-radius:10px;padding:.9rem;font-weight:700;cursor:pointer;} .btn-primary:hover{background:var(--primary-dark);}
        .inventory-tools,.reports-tools{display:flex;gap:.7rem;align-items:center;flex-wrap:wrap;margin-bottom:.9rem;} .input,select{border:1px solid var(--line);border-radius:10px;padding:.7rem .85rem;background:#fff;}
        .pagination{display:flex;justify-content:flex-end;gap:.4rem;margin-top:.7rem;} .page-btn{border:1px solid var(--line);background:#fff;border-radius:8px;padding:.4rem .65rem;}
        .reports-grid{display:grid;grid-template-columns:1.4fr 1fr;gap:.9rem;} .bars{display:flex;align-items:end;gap:.35rem;height:200px;} .bars span{flex:1;background:var(--primary);border-radius:7px 7px 0 0;min-height:32%;}
        .pie{width:220px;height:220px;border-radius:50%;margin:1rem auto;background:conic-gradient(#16a34a 0 35%,#3b82f6 35% 58%,#d97706 58% 73%,#7c3aed 73% 84%,#ec4899 84% 92%,#9ca3af 92% 100%);}
        .coming{min-height:360px;display:grid;place-items:center;text-align:center;color:var(--muted);} .coming h2{margin-bottom:.45rem;color:var(--text);}
        @media (max-width:1180px){.products{grid-template-columns:repeat(3,minmax(0,1fr));}.stats{grid-template-columns:repeat(2,minmax(0,1fr));}}
        @media (max-width:960px){.shell{flex-direction:column;}.sidebar{width:100%;}.menu{grid-template-columns:repeat(2,minmax(0,1fr));}.dashboard-grid,.pos-grid,.reports-grid{grid-template-columns:1fr;}}
        @media (max-width:640px){.menu{grid-template-columns:1fr;}.products{grid-template-columns:repeat(2,minmax(0,1fr));}.stats{grid-template-columns:1fr;}.content{padding:.75rem;}}
    </style>
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="top"><h2 class="title">Poachy</h2><p class="subtitle">Business Manager</p></div>
        <nav class="menu">
            <a href="{{ route('poachy.dashboard') }}" class="{{ ($activePage ?? '') === 'dashboard' ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('poachy.pos') }}" class="{{ ($activePage ?? '') === 'pos' ? 'active' : '' }}">Point of Sale</a>
            <a href="{{ route('poachy.inventory') }}" class="{{ ($activePage ?? '') === 'inventory' ? 'active' : '' }}">Inventory</a>
            <a href="{{ route('poachy.expenses') }}" class="{{ ($activePage ?? '') === 'expenses' ? 'active' : '' }}">Expenses</a>
            <a href="{{ route('poachy.reports') }}" class="{{ ($activePage ?? '') === 'reports' ? 'active' : '' }}">Reports</a>
            <a href="{{ route('poachy.ecommerce') }}" class="{{ ($activePage ?? '') === 'ecommerce' ? 'active' : '' }}">Ecommerce</a>
            <a href="{{ route('poachy.customers') }}" class="{{ ($activePage ?? '') === 'customers' ? 'active' : '' }}">Customers</a>
            <a href="{{ route('poachy.settings') }}" class="{{ ($activePage ?? '') === 'settings' ? 'active' : '' }}">Settings</a>
        </nav>
        <div class="merchant"><div class="avatar">KM</div><div><div style="font-weight:700;">Kenyan Merchant</div><div style="font-size:.8rem;opacity:.85;">Shop Owner</div></div></div>
    </aside>
    <main class="main">
        <header class="topbar">
            <input class="search" placeholder="Search products, orders, customers...">
            <div class="top-actions"><button class="chip">Notifications</button><div class="user">KM</div></div>
        </header>
        <div class="content">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
