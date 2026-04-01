@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

@php
    $productCount = \App\Models\Product::count();
    $orderCount   = \App\Models\Order::count();
    $userCount    = \App\Models\User::count();
    $revenue      = \App\Models\Order::where('status','!=','cancelled')->sum('total_price');
@endphp

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px;">
    <div class="card" style="padding:20px;text-align:center;">
        <div style="font-size:28px;font-weight:700;color:#e94560;">{{ $productCount }}</div>
        <div style="font-size:13px;color:#666;margin-top:4px;">Products</div>
    </div>
    <div class="card" style="padding:20px;text-align:center;">
        <div style="font-size:28px;font-weight:700;color:#e94560;">{{ $orderCount }}</div>
        <div style="font-size:13px;color:#666;margin-top:4px;">Orders</div>
    </div>
    <div class="card" style="padding:20px;text-align:center;">
        <div style="font-size:28px;font-weight:700;color:#e94560;">{{ $userCount }}</div>
        <div style="font-size:13px;color:#666;margin-top:4px;">Customers</div>
    </div>
    <div class="card" style="padding:20px;text-align:center;">
        <div style="font-size:28px;font-weight:700;color:#e94560;">₹{{ number_format($revenue, 2) }}</div>
        <div style="font-size:13px;color:#666;margin-top:4px;">Revenue</div>
    </div>
</div>

<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <h3 style="font-size:15px;font-weight:600;">Recent Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ Add Product</a>
    </div>
    <table>
        <thead>
            <tr><th>Name</th><th>Price</th><th>Stock</th><th>Action</th></tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Product::latest()->take(5)->get() as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>₹{{ number_format($product->price, 2) }}</td>
                <td>
                    <span class="badge {{ $product->stock > 10 ? 'badge-success' : ($product->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td><a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
