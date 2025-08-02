<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 30);
        $products = Product::paginate($perPage);
        return response()->json($products);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_code' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'current_quantity' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_code' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'current_quantity' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $product->update($validated);

        return response()->json($product, 200);
    }

    public function toggleActiveStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json($product, 200);
    }

    public function addStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product->increment('current_quantity', $request->quantity);

        return response()->json($product, 200);
    }

    public function consumeStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($product->current_quantity < $request->quantity) {
            return response()->json(['error' => 'Insufficient stock.'], 400);
        }

        $product->decrement('current_quantity', $request->quantity);

        return response()->json($product, 200);
    }
}
