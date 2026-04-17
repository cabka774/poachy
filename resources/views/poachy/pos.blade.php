@extends('layouts.poachy')

@section('content')
<section class="page">
    <h1>Point of Sale</h1>
    <p class="lead">Select products to add to cart.</p>
    <div class="pos-grid">
        <article class="card">
            <input class="input" style="width:100%;margin-bottom:.7rem;" placeholder="Search products...">
            <div class="products">
                <div class="product"><div class="thumb">R</div><strong>Rice 2kg</strong><div class="stat-title">Stock: 24</div><div class="price">KSh 450</div></div>
                <div class="product"><div class="thumb">O</div><strong>Cooking Oil 1L</strong><div class="stat-title">Stock: 12</div><div class="price">KSh 280</div></div>
                <div class="product"><div class="thumb">S</div><strong>Sugar 1kg</strong><div class="stat-title">Stock: 18</div><div class="price">KSh 150</div></div>
                <div class="product"><div class="thumb">B</div><strong>Bread</strong><div class="stat-title">Stock: 45</div><div class="price">KSh 50</div></div>
                <div class="product"><div class="thumb">M</div><strong>Milk 500ml</strong><div class="stat-title">Stock: 30</div><div class="price">KSh 70</div></div>
                <div class="product"><div class="thumb">E</div><strong>Eggs (tray)</strong><div class="stat-title">Stock: 15</div><div class="price">KSh 450</div></div>
                <div class="product"><div class="thumb">T</div><strong>Tomatoes 1kg</strong><div class="stat-title">Stock: 25</div><div class="price">KSh 120</div></div>
                <div class="product"><div class="thumb">N</div><strong>Onions 1kg</strong><div class="stat-title">Stock: 20</div><div class="price">KSh 100</div></div>
            </div>
        </article>
        <article class="card">
            <strong>Current Sale</strong><div class="stat-title">3 items</div>
            <table><tbody>
                <tr><td>Rice 2kg x1</td><td>KSh 450</td></tr>
                <tr><td>Sugar 1kg x1</td><td>KSh 150</td></tr>
                <tr><td>Milk 500ml x2</td><td>KSh 140</td></tr>
            </tbody></table>
            <div style="display:flex;justify-content:space-between;margin-top:.6rem;font-weight:700;"><span>Subtotal</span><span>KSh 740</span></div>
            <div class="payment"><button class="btn-alt">Cash</button><button class="btn-alt">Mpesa</button><button class="btn-alt">Card</button></div>
            <button class="btn-primary" style="width:100%;">Charge KSh 740</button>
        </article>
    </div>
</section>
@endsection
