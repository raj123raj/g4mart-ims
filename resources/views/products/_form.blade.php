<div class="mb-3">
    <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
    <input id="sku" name="sku" type="text" maxlength="100"
           value="{{ old('sku', $product->sku ?? '') }}"
           class="form-control @error('sku') is-invalid @enderror" required>
    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
    <input id="name" name="name" type="text"
           value="{{ old('name', $product->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <input id="category" name="category" type="text" maxlength="100"
           value="{{ old('category', $product->category ?? '') }}"
           class="form-control @error('category') is-invalid @enderror">
    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="price" class="form-label">Price (₹) <span class="text-danger">*</span></label>
        <input id="price" name="price" type="number" min="0" step="0.01"
               value="{{ old('price', $product->price ?? '') }}"
               class="form-control @error('price') is-invalid @enderror" required>
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
        <input id="quantity" name="quantity" type="number" min="0" step="1"
               value="{{ old('quantity', $product->quantity ?? 0) }}"
               class="form-control @error('quantity') is-invalid @enderror" required>
        @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="reorder_level" class="form-label">Reorder Level <span class="text-danger">*</span></label>
        <input id="reorder_level" name="reorder_level" type="number" min="0" step="1"
               value="{{ old('reorder_level', $product->reorder_level ?? 10) }}"
               class="form-control @error('reorder_level') is-invalid @enderror" required>
        @error('reorder_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
