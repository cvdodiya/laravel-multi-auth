@extends('layouts.admin')

@section('title', 'Add Product')
@section('page-title', 'Add New Product')

@section('content')

<div class="card" style="max-width:600px;">
    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Product Name <span style="color:red">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Wireless Headphones">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" placeholder="Optional product description...">{{ old('description') }}</textarea>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label for="price">Price (₹) <span style="color:red">*</span></label>
                <input type="number" id="price" name="price" value="{{ old('price') }}"
                       step="0.01" min="0" required placeholder="0.00">
            </div>

            <div class="form-group">
                <label for="stock">Stock Quantity <span style="color:red">*</span></label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}"
                       min="0" required placeholder="0">
            </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:8px;">
            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

@endsection
