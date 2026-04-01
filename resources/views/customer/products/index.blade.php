@extends('layouts.app')

@section('title', 'Shop')

@section('content')

<h2 style="font-size:20px;font-weight:600;margin-bottom:20px;">All Products</h2>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px;">
    @forelse($products as $product)
    <div class="card" style="padding:0;overflow:hidden;">
        {{-- Product image placeholder --}}
        <div style="height:160px;background:linear-gradient(135deg,#1a1a2e,#e94560);display:flex;align-items:center;justify-content:center;">
            <span style="font-size:42px;">📦</span>
        </div>

        <div style="padding:16px;">
            <h3 style="font-size:15px;font-weight:600;margin-bottom:4px;">{{ $product->name }}</h3>
            <p style="font-size:12px;color:#999;margin-bottom:10px;">{{ Str::limit($product->description, 60) }}</p>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                <span style="font-size:18px;font-weight:700;color:#e94560;">₹{{ number_format($product->price, 2) }}</span>
                <span style="font-size:12px;color:{{ $product->stock > 10 ? '#28a745' : '#ffc107' }};">
                    {{ $product->stock }} left
                </span>
            </div>

            @auth
            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary" style="width:100%;">Add to Cart</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-secondary" style="width:100%;text-align:center;display:block;">
                Login to Buy
            </a>
            @endauth
        </div>
    </div>
    @empty
    <p style="color:#999;">No products available.</p>
    @endforelse
</div>

<div style="margin-top:30px;">{{ $products->links() }}</div>

@endsection
