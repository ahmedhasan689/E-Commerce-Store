<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::paginate();
        return view('front.products.index', [
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', '=', $slug)->firstOrFail();  
        return view('front.products.show', [
            'product' => $product,
        ]); 
    }
}
