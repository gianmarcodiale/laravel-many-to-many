<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define a list of categories
        $categories = ['Front-End', 'Back-End', 'Programming', 'Full-Stack', 'Design', 'Operations'];

        // Iterate inside the array for database seeding
        foreach ($categories as $category) {
            $newCat = new Category();
            $newCat->name = $category;
            $newCat->slug = Str::slug($newCat->name);
            $newCat->save();
        }
    }
}
