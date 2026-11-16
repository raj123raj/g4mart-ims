@extends('layouts.app')

@section('title', 'Products | G4Mart IMS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-1">Product Management</h1>
        <p class="text-muted mb-0">Add, update, search and remove products.</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>

<form method="GET" action="{{ route('products.index') }}" class="card card-body border-0 shadow-sm mb-3">
    <div class="input-group">
        <input type="search" name="search" value="{{ $search }}" class="form-control"
               placeholder="Search by product name or SKU">
        <button class="btn btn-dark" type="submit">Search</button>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear</a>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>SKU</th><th>Product</th><th>Category</th><th>Price (₹)</th>
                    <th>Quantity</th><th>Stock Status</th><th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td class="fw-semibold">{{ $product->name }}</td>
                        <td>{{ $product->category ?: '—' }}</td>
                        <td>{{ number_format((float) $product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @if ($product->is_low_stock)
                                <span class="badge text-bg-danger">Low stock</span>
                            @else
                                <span class="badge text-bg-success">Available</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}"
                                  class="d-inline" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No products found. Add a product or change your search.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
