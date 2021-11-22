<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::join('categories', 'categories.id', '=', 'products.category_id')
        ->select([
            'products.*',
            'categories.name as category_name',
        ])
        // ->withoutGlobalScopes([ActiveStatusScope::class])
        ->paginate(5);

        $success = session()->get('success');

        return view('admin.products.index', compact('products', 'success'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::withTrashed()->get();
        $product = new Product;
        return view('admin.products.create', compact('categories', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Product::validateRules());

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $product = Product::create($request->all()); 

        return redirect()->route('products.index')->with('success', 'Product ($product->name) Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::withoutGlobalScope('active')->findOrFail($id);
        $categories = Category::withTrashed()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::withoutGlobalScope('active')->findOrFail($id);

        

        $request->validate(Product::validateRules());


        /* Filesystem - Disks [
            loacal => Storage/app,
            public => storage/app/public
            s3 => Amazon Drive
            custom => Defined By Us !
            ]
        */

        // Image Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // UploadedFile Objects 

            $image_path = $file->store('/', [
                'disk' => 'uploads',
            ]);
            $request->merge([
                'image_path' => $image_path,
            ]); 
            
        }


        $product->update( $request->all() );

        return redirect()->route('products.index')->with('success', 'Product ' . $product->name . ' Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::withoutGlobalScope('active')->findOrFail($id);
        $product->delete();

        // Storage::disk('uploads')->delete($product->image_path);
        // unlink(public_path('uploads/' . $product->image_path));

        return redirect()->route('products.index')->with('success', 'Product ' . ($product->name) .  ' Deleted');

    }

    public function trash() 
    {
        $products = Product::withoutGlobalScope('active')->onlyTrashed()->paginate(5);
        return view('admin.products.trash', compact('products'));
    }

    public function restore(Request $request, $id = null) 
    {
        if ($id) {
            $product = Product::withoutGlobalScope('active')->onlyTrashed()->findOrFail($id);
            $product->restore();   
    
            return redirect()->route('products.index')->with('success', 'Product ' . ($product->name) .  ' Restored');
        }

        $product = Product::withoutGlobalScope('active')->onlyTrashed()->restore();
        return redirect()->route('products.index')->with('success', 'All Trashed Product Restored');
    }

    public function forceDelete($id = null) 
    {
        if ($id) {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->forceDelete();   
    
            return redirect()->route('products.index')->with('success', 'Product ' . ($product->name) .  ' Deleted');
        }

        $product = Product::onlyTrashed()->forceDelete();
        return redirect()->route('products.index')->with('success', 'All Trashed Product Deleted');
    }

}
