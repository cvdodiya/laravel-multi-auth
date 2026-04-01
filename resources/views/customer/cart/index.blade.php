@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')

<h2 style="font-size:20px;font-weight:600;margin-bottom:20px;">Your Cart</h2>

@if(empty($cart))
    <div class="card" style="text-align:center;padding:48px;">
        <div style="font-size:48px;margin-bottom:16px;">🛒</div>
        <h3 style="margin-bottom:8px;font-size:16px;">Your cart is empty</h3>
        <p style="color:#999;margin-bottom:20px;font-size:14px;">Add some products to get started.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Browse Products</a>
    </div>
@else

<div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;">

    {{-- ── Cart Items ───────────────────────────────────────────────────── --}}
    <div class="card" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $productId => $item)
                <tr>
                    <td><strong>{{ $item['name'] }}</strong></td>
                    <td>₹{{ number_format($item['price'], 2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.update', $productId) }}" style="display:flex;gap:6px;align-items:center;">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['qty'] }}" min="1"
                                   style="width:60px;padding:4px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px;">
                            <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                        </form>
                    </td>
                    <td>₹{{ number_format($item['price'] * $item['qty'], 2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $productId) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">✕</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ── Order Summary ────────────────────────────────────────────────── --}}
    <div class="card">
        <h3 style="font-size:15px;font-weight:600;margin-bottom:16px;">Order Summary</h3>

        @foreach($cart as $item)
        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:8px;color:#666;">
            <span>{{ $item['name'] }} × {{ $item['qty'] }}</span>
            <span>₹{{ number_format($item['price'] * $item['qty'], 2) }}</span>
        </div>
        @endforeach

        <hr style="margin:14px 0;border:none;border-top:1px solid #eee;">

        <div style="display:flex;justify-content:space-between;font-size:16px;font-weight:700;margin-bottom:20px;">
            <span>Total</span>
            <span style="color:#e94560;">₹{{ number_format($total, 2) }}</span>
        </div>

        <form method="POST" action="{{ route('cart.checkout') }}">
            @csrf
            <button type="submit" class="btn btn-primary" style="width:100%;padding:12px;font-size:15px;">
                Place Order
            </button>
        </form>

        <a href="{{ route('home') }}" style="display:block;text-align:center;margin-top:12px;font-size:13px;color:#999;">
            ← Continue Shopping
        </a>
    </div>

</div>

@endif

@endsection
