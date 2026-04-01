<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    // ── Shop listing page ─────────────────────────────────────────────────────
    public function index()
    {
        $products = Product::where('stock', '>', 0)->latest()->paginate(12);

        return view('customer.products.index', compact('products'));
    }

    // ── Single product detail ─────────────────────────────────────────────────
    public function show(Product $product)
    {
        return view('customer.products.show', compact('product'));
    }
}
