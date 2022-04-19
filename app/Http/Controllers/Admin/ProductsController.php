<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DB::first();
        // $this->authorize('viewAny', Product::class);

        // dd($data);
        $user = Auth::user()->type; // 12
        // dd($user);
        if ($user == 'admin' && $user == 'super-admin') {
            $this->authorize('viewAny', Product::class);
        }

        $products = Product::with('category.parent')
        ->withoutGlobalScopes([ActiveStatusScope::class])
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
        // if (!Gate::allows('products.create')) {
        //     abort(403);
        // };

        $categories = Category::withTrashed()->get();

        // $this->authorize('create', Product::class);

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

        return $product->ratings()->dd();
        // $this->authorize('view', Product::class);

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

        // $this->authorize('products.update', Product::class);

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

        $this->authorize('products.update', Product::class);

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

        // $result = DB::table('products')->delete();

        // dd($result);
        // Gate::authorize('products.delete');

        // $user = User::find(12); // ID
        // Gate::forUser($user)->denies('products.delete');

        $product = Product::findOrFail($id);

        // $this->authorize('products.delete', $product);

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
