<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * ProductController — full CRUD for admin.
 * All routes in this controller are protected by middleware('auth:admin').
 */
class ProductController extends Controller
{
    // ── List all products ─────────────────────────────────────────────────────
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    // ── Show create form ──────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.products.create');
    }

    // ── Store new product ─────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    // ── Show edit form ────────────────────────────────────────────────────────
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // ── Update existing product ───────────────────────────────────────────────
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    // ── Delete product ────────────────────────────────────────────────────────
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }

    // ── Manual stock adjustment (e.g. restock) ────────────────────────────────
    public function adjustStock(Request $request, Product $product)
    {
        $request->validate([
            'action'   => 'required|in:increment,decrement',
            'quantity' => 'required|integer|min:1',
        ]);

        $qty = (int) $request->quantity;

        if ($request->action === 'increment') {
            // Atomic: runs UPDATE products SET stock = stock + $qty WHERE id = ?
            $product->increment('stock', $qty);
        } else {
            if ($product->stock < $qty) {
                return back()->withErrors(['quantity' => 'Not enough stock to remove.']);
            }
            // Atomic: runs UPDATE products SET stock = stock - $qty WHERE id = ?
            $product->decrement('stock', $qty);
        }

        return back()->with('success', "Stock updated. New stock: {$product->fresh()->stock}");
    }
}
