<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;
use App\Models\Product;

class ProfilesController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return $product->ratings()->dd();
        // $this->authorize('view', Product::class);

        return view('admin.products.show', compact('product'));;
    }
}
