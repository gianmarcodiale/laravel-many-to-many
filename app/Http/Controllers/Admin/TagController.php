<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // Pass the tags list
        $tags = Tag::orderByDesc('id')->get();
        // Create index page for tags render
        return view('admin.tags.index', compact('tags'));
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
            'name' => ['required', 'unique:tags']
        ]);
        // Generate slug
        $slug = Str::slug($request->name);
        $validated_data['slug'] = $slug;
        // Save validated data
        Tag::create($validated_data);
        // Redirect to GET route
        return redirect()->back()->with('message', "Tag $slug Added Succesfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        // Create method for updating categories
        //dd($request->all());
        // Validate data
        $validated_data = $request->validate([
            'name' => ['required', Rule::unique('tags')->ignore($tag)]
        ]);
        // Generate slug
        $slug = Str::slug($request->name);
        $validated_data['slug'] = $slug;
        // Update validated data
        $tag->update($validated_data);
        // Redirect to a GET route
        return redirect()->back()->with('message', "Tag $slug Updated Succesfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        // Create method for delete
        $tag->delete();
        // Redirect to GET route
        return redirect()->back()->with('message', "Tag Deleted Succesfully");
    }
}
