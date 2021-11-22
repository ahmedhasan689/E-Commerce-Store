<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        return Product::paginate();
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);  
        return $product; 
    }
}
