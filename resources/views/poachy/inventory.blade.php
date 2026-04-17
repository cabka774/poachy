@extends('layouts.poachy')

@section('content')
<section class="page">
    <h1>Inventory Management</h1>
    <p class="lead">Manage your product stock and pricing.</p>
    <div class="inventory-tools">
        <button class="btn-primary" style="width:auto;padding:.7rem 1rem;">+ Add Product</button>
        <input class="input" style="min-width:260px;flex:1;" placeholder="Search by name or SKU...">
        <select><option>All Categories</option><option>Grains</option><option>Basics</option><option>Cooking</option></select>
    </div>
    <article class="card table-wrap">
        <table>
            <thead><tr><th>Product</th><th>SKU</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <tr><td>Rice 2kg</td><td>GRN-001</td><td>Grains</td><td>KSh 450</td><td>24</td><td><span class="badge ok">In Stock</span></td><td>Edit | Delete</td></tr>
                <tr><td>Cooking Oil 1L</td><td>CKG-002</td><td>Cooking</td><td>KSh 280</td><td>3</td><td><span class="badge warn">Low Stock</span></td><td>Edit | Delete</td></tr>
                <tr><td>Sugar 1kg</td><td>BSC-003</td><td>Basics</td><td>KSh 150</td><td>5</td><td><span class="badge warn">Low Stock</span></td><td>Edit | Delete</td></tr>
                <tr><td>Bread</td><td>BKY-004</td><td>Bakery</td><td>KSh 50</td><td>45</td><td><span class="badge ok">In Stock</span></td><td>Edit | Delete</td></tr>
                <tr><td>Laundry Soap</td><td>HYG-005</td><td>Hygiene</td><td>KSh 80</td><td>0</td><td><span class="badge bad">Out of Stock</span></td><td>Edit | Delete</td></tr>
            </tbody>
        </table>
        <div class="pagination"><button class="page-btn">Prev</button><button class="page-btn">1</button><button class="page-btn">2</button><button class="page-btn">Next</button></div>
    </article>
</section>
@endsection
