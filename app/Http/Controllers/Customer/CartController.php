<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * CartController
 *
 * Cart lives in the PHP session as:
 * [
 *   'product_id' => [
 *       'name'  => 'T-Shirt',
 *       'price' => 299.00,
 *       'qty'   => 2,
 *   ],
 *   ...
 * ]
 */
class CartController extends Controller
{
    // ── Show the cart page ────────────────────────────────────────────────────
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return view('customer.cart.index', compact('cart', 'total'));
    }

    // ── Add a product to the cart ─────────────────────────────────────────────
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty     = (int) $request->quantity;

        // Check stock before adding
        if (! $product->hasStock($qty)) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        // Pull existing cart from session (or empty array)
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            // Product already in cart — bump the quantity
            $cart[$product->id]['qty'] += $qty;
        } else {
            // New entry
            $cart[$product->id] = [
                'name'  => $product->name,
                'price' => $product->price,
                'qty'   => $qty,
            ];
        }

        // Save the updated cart back to the session
        session()->put('cart', $cart);

        return back()->with('success', "{$product->name} added to cart!");
    }

    // ── Update quantity of a cart item ────────────────────────────────────────
    public function update(Request $request, int $productId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = (int) $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    // ── Remove a single item from the cart ───────────────────────────────────
    public function remove(int $productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed from cart.');
    }

    // ── Checkout: create Order record + decrement stock ───────────────────────
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Wrap everything in a DB transaction.
        // If ANY step fails, the entire operation is rolled back automatically.
        DB::transaction(function () use ($cart) {

            // 1. Calculate total
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

            // 2. Create the parent Order record
            $order = Order::create([
                'user_id'     => auth()->id(),
                'total_price' => $total,
                'status'      => Order::STATUS_PENDING,
            ]);

            // 3. Loop through cart items
            foreach ($cart as $productId => $item) {

                // Create an OrderItem row for each product
                $order->items()->create([
                    'product_id' => $productId,
                    'quantity'   => $item['qty'],
                    'price'      => $item['price'],   // snapshot price at time of order
                ]);

                // Decrement stock atomically — one SQL UPDATE per product
                // Runs: UPDATE products SET stock = stock - $qty WHERE id = ?
                Product::where('id', $productId)
                       ->decrement('stock', $item['qty']);
            }
        });

        // 4. Clear the cart from the session
        session()->forget('cart');

        return redirect()
            ->route('home')
            ->with('success', 'Order placed successfully! Thank you.');
    }
}
