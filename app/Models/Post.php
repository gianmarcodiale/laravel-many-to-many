<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    // Create the fillable date for the model
    // Add 'category_id' because we have added a new relations between tables
    protected $fillable = ['title', 'author', 'content', 'cover_image', 'slug', 'category_id', 'user_id'];
    // Create a static function for slug generation
    /**
     * # Generate a slug from post title
     * 
     * @return slug generated form post title
     */
    public static function generateSlug($title)
    {
        return Str::slug($title, '-');
    }

    // Create the relations between Post and Category with one to many
    /**
     * The category that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo // -> BelongsTo: This indicates what the function returns and is not mandatory
    {
        return $this->belongsTo(Category::class);
    }

    // Create the relations between Tag and Post
    /**
     * The roles that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the user that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
