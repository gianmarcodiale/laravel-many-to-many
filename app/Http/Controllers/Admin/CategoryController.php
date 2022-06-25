<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show all categories list
        $categories = Category::orderByDesc('id')->get();
        // Return view index for categories
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create function for store new category data
        // Validate data
        $validated_data = $request->validate([
            'name' => ['required', 'unique:categories']
        ]);
        // Generate slug
        $slug = Str::slug($request->name);
        $validated_data['slug'] = $slug;
        // Save validated data
        Category::create($validated_data);
        // Redirect to GET route
        return redirect()->back()->with('message', "Category $slug Added Succesfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // Create method for updating categories
        //dd($request->all());
        // Validate data
        $validated_data = $request->validate([
            'name' => ['required', Rule::unique('categories')->ignore($category)]
        ]);
        // Generate slug
        $slug = Str::slug($request->name);
        $validated_data['slug'] = $slug;
        // Update validated data
        $category->update($validated_data);
        // Redirect to a GET route
        return redirect()->back()->with('message', "Category $slug Updated Succesfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Create method for delete
        $category->delete();
        // Redirect to GET route
        return redirect()->back()->with('message', "Category Deleted Succesfully");
    }
}
