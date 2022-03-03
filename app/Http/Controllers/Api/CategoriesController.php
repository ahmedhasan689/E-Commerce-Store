<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\CategoryCollection;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->query('parent_id'), function($query, $value) {
            $query->where('parent_id', '=', $value);
        })->get();

        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'parent_id' => 'nullable|int|exists:categories,id',
        ]);

        $category = Category::create($request->all());

        $category->refresh()->load('children'); // Select After Create

        // return response()->json($category, 201);

        return Response::json($category, 201, [
            'x-application-name' => config('app.name'),
        ]);



        /* return new JsonResponse($category, 201, [
            'x-application-name' => config('app.name'),
        ]); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::with('children')->findOrFail($id);

        return new CategoryResource($category);

        return [
            'id' => $category->id,
            'title' => $category->name,
            'sub_categories' => $category->children,
        ];
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
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required',
            'parent_id' => 'nullable|int|exists:categories,id',
         ]);

         $category->update($request->all());

         return new JsonResponse([
            'message' => 'Category Updated',
            'category' => $category,
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

         return new JsonResponse([
            'message' => 'Category Deleted',
         ]);
    }
}
