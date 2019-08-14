<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $is_exist = Category::all();

        if (!$is_exist->count()) {
            $category = new Category();
            $category->name = 'Development';
            $category->slug = 'development';
            $category->icon_class = 'fa-chart-line';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'Business';
            $category->slug = 'business';
            $category->icon_class = 'fa-business-time';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'IT & Software';
            $category->slug = 'IT-software';
            $category->icon_class = 'fa-laptop';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'Marketing';
            $category->slug = 'marketing';
            $category->icon_class = 'fa-funnel-dollar';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'Lifestyle';
            $category->slug = 'lifestyle';
            $category->icon_class = 'fa-heartbeat';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'Photography';
            $category->slug = 'photography';
            $category->icon_class = 'fa-camera-retro';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'Health & Fitness';
            $category->slug = 'health-fitness';
            $category->icon_class = 'fa-medkit';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'Teacher Training';
            $category->slug = 'teacher-training';
            $category->icon_class = 'fa-chalkboard-teacher';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'Music';
            $category->slug = 'music';
            $category->icon_class = 'fa-music';
            $category->is_active = 1;
            $category->save();

            $category = new Category();
            $category->name = 'Academics';
            $category->slug = 'academics';
            $category->icon_class = 'fa-user-graduate';
            $category->is_active = 1;
            $category->save();
        }
    }
}
