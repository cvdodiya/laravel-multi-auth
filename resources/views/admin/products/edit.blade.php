@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')

<div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

    {{-- ── Edit Form ────────────────────────────────────────────────────── --}}
    <div class="card">
        <h3 style="font-size:15px;font-weight:600;margin-bottom:20px;">Product Details</h3>

        <form method="POST" action="{{ route('admin.products.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name <span style="color:red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label for="price">Price (₹) <span style="color:red">*</span></label>
                    <input type="number" id="price" name="price"
                           value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock Quantity <span style="color:red">*</span></label>
                    <input type="number" id="stock" name="stock"
                           value="{{ old('stock', $product->stock) }}" min="0" required>
                </div>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    {{-- ── Stock Adjustment Panel ───────────────────────────────────────── --}}
    <div class="card">
        <h3 style="font-size:15px;font-weight:600;margin-bottom:4px;">Stock Adjustment</h3>
        <p style="font-size:13px;color:#666;margin-bottom:16px;">
            Current stock: <strong style="color:#e94560;font-size:18px;">{{ $product->stock }}</strong>
        </p>

        <form method="POST" action="{{ route('admin.products.stock', $product) }}">
            @csrf

            <div class="form-group">
                <label>Action</label>
                <select name="action">
                    <option value="increment">Add stock (+)</option>
                    <option value="decrement">Remove stock (-)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="qty">Quantity</label>
                <input type="number" id="qty" name="quantity" value="1" min="1" required>
            </div>

            <button type="submit" class="btn btn-success" style="width:100%;">Update Stock</button>
        </form>

        <hr style="margin:20px 0;border:none;border-top:1px solid #eee;">

        {{-- ── Danger Zone ─────────────────────────────────────────────── --}}
        <h4 style="font-size:13px;font-weight:600;color:#dc3545;margin-bottom:12px;">Danger Zone</h4>
        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
              onsubmit="return confirm('Permanently delete {{ $product->name }}?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width:100%;">Delete Product</button>
        </form>
    </div>

</div>

@endsection
