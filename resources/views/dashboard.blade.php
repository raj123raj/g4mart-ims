@extends('layouts.app')

@section('title', 'Dashboard | G4Mart IMS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Inventory Dashboard</h1>
        <p class="text-muted mb-0">Overview of G4Mart Retail stock.</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted">Total Products</div>
                <div class="display-6 fw-semibold">{{ $totalProducts }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted">Total Units in Stock</div>
                <div class="display-6 fw-semibold">{{ number_format($totalStock) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted">Low-stock Products</div>
                <div class="display-6 fw-semibold text-danger">{{ $lowStockProducts->count() }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h2 class="h5 mb-0">Low-stock Alerts</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>SKU</th>
                    <th>Product</th>
                    <th>Available Quantity</th>
                    <th>Reorder Level</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td><span class="badge text-bg-danger">{{ $product->quantity }}</span></td>
                        <td>{{ $product->reorder_level }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No low-stock products.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
