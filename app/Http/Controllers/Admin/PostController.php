<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Mail\NewPostCreated;
use App\Mail\PostUpdatedAdminMessage;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Post $post)
    {
        // Save the logged user in a variable
        $authUser= Auth::id();

        // Show only the post created by the logged user
        $posts = Post::orderByDesc('id')->where('user_id', '=', $authUser)->get();

        // Or we can use
        // $posts = Auth::user()->posts;

        // Or without saving the authenticated user in a variable
        // $posts = Post::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
        // dd($posts);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Pass all the category list to the create function in the PostController
        $categories = Category::all();

        // Pass all the tag list
        $tags = Tag::all();
        // dd($categories);

        // Return view with form for creating a new post
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // dd($request->all());
        // Store the newly created post into the database
        // Validate data
        $validated_data = $request->validated();

        // Verify if inserted id exist in the category list -> check PostRequest.php
        // Generate slug for new post
        $slug = Post::generateSlug($request->title);

        // Save the validated slug into the slug param
        $validated_data['slug'] = $slug;

        // Assign the post to the authenticated user who created it
        $validated_data['user_id'] = Auth::id();

        // Verify if the request contains the file cover_image and validate if so
        // ddd($request->hasFile('cover_image')); // Option 1
        // Option 2 -> array_key_exists('cover_image', $request->all())
        if ($request->hasFile('cover_image')) {
            // Validate file
            $request->validate([
                "cover_image" => "nullable|image|max:250" // -> max:250 means max 250kb
            ]);
            // Save the file in the file system & retrieve the file
            //ddd($request->all());
            $image_path = Storage::put("post_images", $request->cover_image);
            //ddd($image_path);
            // Pass the array in the validated data and save
            $validated_data["cover_image"] = $image_path;
        }
        //dd($validated_data);

        // Create the new post (and save in a variable for inserting tags in post)
        $newPost = Post::create($validated_data);

        // Call the method attach for assigning tags to a post
        $newPost->tags()->attach($request->tags);

        // Use of return to block the redirect for the moment
        // return (new NewPostCreated($newPost))->render();

        // Send the email using the user instance inside the request 
        Mail::to($request->user())->send(new NewPostCreated($newPost));

        // Or send email using email address
        // Mail::to('test@example.com')->send(new NewPostCreated($newPost));

        // Redirect to GET route
        return redirect()->route('admin.posts.index')->with('message', 'Post Created Succesfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // Return the single post by clicking on view btn
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // Pass all the category list to the create function in the PostController
        // dd($post);
        $categories = Category::all();

        // Pass all the tag list
        $tags = Tag::all();

        // We can create a variable data for passing all the necessary data inside an array
        // $data = [
        //     'post' => $post,
        //     'categories' => Category::all(),
        //     'tags' => Tag::all(),
        // ];
        // And then pass the $data variable inside the compact method. This is for a best pratice in Laravel for avoid a too long compact list

        // Return view with the form for editing the single post
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        // Return the updated data from the single post
        // Create the variable with the validated data
        $validated_data = $request->validated();

        // Generate slug with the post title by defining a function for the Str in the
        $slug = Post::generateSlug($request->title);
        // dd($slug);

        // Save the validated slug into the slug param
        $validated_data['slug'] = $slug;

        // Verify if the request contains the file cover_image
        // ddd($request->hasFile('cover_image')); // Option 1
        // Option 2 -> array_key_exists('cover_image', $request->all())
        if ($request->hasFile('cover_image')) {
            // Validate file
            $request->validate([
                "cover_image" => "nullable|image|max:250" // -> max:250 means max 250kb
            ]);
            // Delete the file that was previeouly updated before inserting the new one
            Storage::delete($post->cover_image);
            // Save the file in the file system & retrieve the file
            //ddd($request->all());
            $image_path = Storage::put("post_images", $request->cover_image);
            //ddd($image_path);
            // Pass the array in the validated data and save
            $validated_data["cover_image"] = $image_path;
        }

        // Create instance
        $post->update($validated_data);

        // Sync validated_data
        $post->tags()->sync($request->tags);

        // This redirect to the mail template
        // return (new PostUpdatedAdminMessage($post))->render();
        Mail::to('admin@example.com')->send(new PostUpdatedAdminMessage($post));

        // Redirect to a GET route
        return redirect()->route('admin.posts.index')->with('message', 'Post Updated Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Create a route for post delete
        // Delete the file inside the storage also
        Storage::delete($post->cover_image);

        // Delete the post
        $post->delete();

        // Redirect to a GET route
        return redirect()->route('admin.posts.index')->with('message', 'Post Deleted Succesfully');
    }
}
