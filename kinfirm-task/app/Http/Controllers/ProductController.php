<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::paginate($request->get('per_page', 10));
        return response()->json([
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }



    public function show($id)
    {
        $product = Cache::remember("product_{$id}", now()->addMinutes(10), function () use ($id) {
            return Product::find($id);
        });

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

}
