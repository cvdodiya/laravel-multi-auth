@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')

<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h3 style="font-size:15px;font-weight:600;">All Products ({{ $products->total() }})</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><strong>{{ $product->name }}</strong></td>
                <td style="color:#666;max-width:200px;">{{ Str::limit($product->description, 50) }}</td>
                <td>₹{{ number_format($product->price, 2) }}</td>
                <td>
                    <span class="badge {{ $product->stock > 10 ? 'badge-success' : ($product->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">Edit</a>

                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Delete {{ $product->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;color:#999;padding:30px;">
                    No products yet. <a href="{{ route('admin.products.create') }}">Add one</a>.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $products->links() }}
    </div>
</div>

@endsection
