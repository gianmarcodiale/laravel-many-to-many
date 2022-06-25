<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tag;
use Faker\Generator as Faker;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // // Define a list of tags
        // $tags = ['coding', 'laravel', 'css', 'js', 'vue', 'sql', 'starwars', 'games', 'tech', 'pcgames'];

        // // Iterate inside the array for database seeding
        // foreach ($tags as $tag) {
        //     $newTag = new Tag();
        //     $newTag->name = $tag;
        //     $newTag->slug = Str::slug($newTag->name);
        //     $newTag->save();
        // }

        // Iterate for creating new faker data
        for ($i = 0; $i < 10; $i++) {
            $newTag = new Tag();
            $newTag->name = $faker->word;
            $newTag->slug = Str::slug($newTag->name);
            $newTag->save();
        }
        // Possible seed error for duplicate words, try resend the db:seed multiple times
    }
}
