<?php

use App\Models\Post;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++) {
            $newPost = new Post();
            $newPost->title = $faker->sentence(3);
            $newPost->content = $faker->text(500);
            $newPost->author = $faker->name();
            $newPost->slug = Str::slug($newPost->title, '-');
            $newPost->cover_image = $faker->imageUrl(600, 300, 'Post', true, $newPost->slug, true);
            $newPost->save();
        }
    }
}
