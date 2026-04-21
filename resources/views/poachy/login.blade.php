<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poachy Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#16a34a; --primary-dark:#15803d; --muted:#6b7280; --line:#e5e7eb; }
        * { box-sizing:border-box; } body { margin:0; font-family:"Inter",sans-serif; background:linear-gradient(135deg,#eefcf2,#f6f7f8 45%); min-height:100vh; display:grid; place-items:center; padding:1.5rem; }
        .card { width:min(430px,100%); background:#fff; border-radius:18px; border:1px solid var(--line); box-shadow:0 20px 40px rgba(16,24,40,.08); padding:2rem; }
        .brand { text-align:center; margin-bottom:1.7rem; } .logo { color:var(--primary); font-size:2rem; font-weight:800; margin:0; } .sub { margin:.2rem 0 0; color:var(--muted); font-size:.87rem; }
        h2 { margin:0; font-size:1.7rem; } p { margin:.45rem 0 1.5rem; color:var(--muted); font-size:.93rem; }
        label { display:block; margin-bottom:.4rem; font-size:.8rem; color:#4b5563; text-transform:uppercase; letter-spacing:.08em; font-weight:600; } input { width:100%; border:1px solid var(--line); border-radius:10px; padding:.85rem .95rem; font-size:.95rem; margin-bottom:1rem; }
        .meta { display:flex; justify-content:flex-end; margin-bottom:1rem; } .link { color:var(--primary); text-decoration:none; font-size:.88rem; font-weight:600; }
        .btn { width:100%; border:0; background:var(--primary); color:#fff; border-radius:10px; padding:.9rem; font-weight:700; text-decoration:none; display:block; text-align:center; }
        .btn:hover { background:var(--primary-dark); } .register { text-align:center; margin-top:1rem; color:var(--muted); font-size:.9rem; }
    </style>
</head>
<body>
<div class="card">
    <div class="brand"><h1 class="logo">Poachy</h1><p class="sub">The Merchant's Ledger</p></div>
    <h2>Welcome back</h2>
    <p>Securely access your merchant dashboard.</p>
    <form method="POST" action="{{ route('poachy.login.submit') }}">
        @csrf

        <label>Email Address</label>
        <input type="email" name="email" value="{{ old('email', 'admin@poachy.com') }}" autocomplete="email" required>
        @error('email')
            <div style="margin:-0.6rem 0 1rem; color:#dc2626; font-size:.85rem; font-weight:600;">{{ $message }}</div>
        @enderror

        <label>Password</label>
        <input type="password" name="password" value="" autocomplete="current-password" required>
        @error('password')
            <div style="margin:-0.6rem 0 1rem; color:#dc2626; font-size:.85rem; font-weight:600;">{{ $message }}</div>
        @enderror

        <div class="meta">
            <label style="display:flex; align-items:center; gap:.5rem; margin:0; text-transform:none; letter-spacing:0; font-weight:600;">
                <input type="checkbox" name="remember" value="1" style="width:auto; margin:0;">
                Remember me
            </label>
        </div>

        <button type="submit" class="btn">Sign In to Poachy</button>
    </form>
    <div class="register">Don't have an account? <a href="#" class="link">Register</a></div>
</div>
</body>
</html>
