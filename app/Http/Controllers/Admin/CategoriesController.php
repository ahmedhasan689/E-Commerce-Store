<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        /*
        SELECT * FROM 
        categories INNER JOIN categories as parents ON parents.id = categories.parent_id
        */

        // SELECT * FROM categories WHERE status = 'acitve'
        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id' )
        ->select([
            'categories.*',
            'parents.name as parent_name',
        ])
        ->orderBy('categories.created_at', 'DESC')
        ->orderBy('categories.name', 'DESC')
        ->withTrashed()
        ->get();

        $title = 'Categories List';

        $success = session()->get('success');
        // session()->forget('success');

        return view('Admin.categories.index', compact('categories', 'title', 'success'));


    }

    public function create()
    {
        $parents = Category::all();
        $category = new Category;
        return view('admin.categories.create', compact('category', 'parents'));
    }
 
    public function store(CategoryRequest $request)
    {   

        // Validation [ >>>>>> We Made a CategoryRequest In HTTP File For Validation <<<<<< ]...
         /* $rules = [
            'name'        => 'min:3|max:255|required|string|unique:categories',
            'parent_id'   => 'required|integer|exists:categories,id',
            'description' => 'nullable|min:5|max:255',
            'image'       => 'required|image|max:512000|dimensions:min_width=300,min_height=300',
            'status'      => 'required|in:active,draft',
        ]; */

        // Validation Lifecycle ...
        /* $data = $request->all();
        $valid = Validator::make($data, $rules);
        // $clean = $valid->validate();
        if ($valid->fails()){
            // return $valid->errors(); (1)
            return redirect()->back()->withErrors($valid)->withInput(); /// (2)
        }; */

        
        // $request->validate($rules);     
        // $this->validate($request, $rules);

        // Create
        $category = Category::create([
            'name' => $request->post('name'), 
            'slug' => Str::slug($request->post('name')),
            'parent_id' => $request->post('parent_id'),
            'description' => $request->post('description'),
            'status' => $request->post('status', 'active'),
        ]);
        
        // Post Redirect Get [PRG]
        return redirect()->route('categories.index')->with('success', 'Category Created');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }
        
        $parents = Category::where('id', '<>', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(CategoryRequest $request, $id)
    {

         // Validation [ >>>>>> We Made a CategoryRequest In HTTP File For Validation <<<<<< ]...
         /* $rules = [
            'name'        => 'min:3|max:255|required|string|unique:categories',
            'parent_id'   => 'required|integer|exists:categories,id',
            'description' => 'nullable|min:5|max:255',
            'image'       => 'required|image|max:512000|dimensions:min_width=300,min_height=300',
            'status'      => 'required|in:active,draft',
        ]; */

        // Validation Lifecycle ...
        /* $data = $request->all();
        $valid = Validator::make($data, $rules);
        // $clean = $valid->validate();
        if ($valid->fails()){
            // return $valid->errors(); (1)
            return redirect()->back()->withErrors($valid)->withInput(); /// (2)
        }; */

        
        // $request->validate($rules);     
        // $this->validate($request, $rules);
        $category = Category::find($id);

        // Method (1)
        /*
            $category->name = $request->post('name');
            $category->parent_id = $request->post('parent_id');
            $category->description = $request->post('description');
            $category->status = $request->post('status');
            $category->save();
        */
        #Method (2) -> Mass Assignment
        $category->update([
            'name' => $request->post('name'),
            'parent_id' => $request->post('parent_id'),
            'description' => $request->post('description'),
            'status' => $request->post('status'),
        ]);
        // Another Syntax In Method (2)
        /*
            $category->update($request->all()); 
        */

        // Method (3) -> Mass Assignment -> Required $fillable var In Model File

        /*
            $category->fill( $request->all())->save();
        */
        
        // PRG 
        return redirect()->route('categories.index');

    }

    public function destroy($id)
    {
        // $category = Category::find($id);
        // $category->delete(); Method (1)
        Category::destroy($id); //Method (2)

        // session()->put('success', 'Category Deleted');
        // session()->get('success');
        // session()->forget('success');
        // session()->flash('success', 'Category Deleted');
        
        // Method (3) 
        // Category::where('id', '=', $id)->delete(); 
        return redirect()->route('categories.index')->with('success', 'Category Deleted');
    }
}
