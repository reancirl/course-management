<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesAndCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default image path for courses
        $defaultImagePath = 'images/elevate_logo.webp';

        // Insert course categories
        $categories = [
            'Freebies',
            'Learning',
            'Business & Templates'
        ];

        foreach ($categories as $category) {
            DB::table('course_categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert courses
        $courses = [
            [
                'name' => 'Cartoons',
                'description' => 'A collection of cartoon resources.',
                'img' => $defaultImagePath,
                'course_category_id' => 1, // Freebies
                'gdrive_link' => 'https://drive.google.com/drive/folders/10F3wtt7CtFwyWlU4YQIF8V8oxTbwZ5aD?usp=sharing',
                'is_free' => true,
                'price' => 0.00,
            ],
            [
                'name' => 'Coffee',
                'description' => 'Coffee resource.',
                'img' => $defaultImagePath,
                'course_category_id' => 1, // Freebies
                'gdrive_link' => 'https://drive.google.com/drive/folders/1-D_xiXJv2MIxsgBV3fQSzJGrOTMll3Ql?usp=sharing',
                'is_free' => true,
                'price' => 0.00,
            ],
            [
                'name' => 'Digital Products',
                'description' => 'Digital products collection.',
                'img' => $defaultImagePath,
                'course_category_id' => 1, // Freebies
                'gdrive_link' => 'https://drive.google.com/drive/folders/1X-JFSHBepxJZK47YOetivkjYsEwg4-4H?usp=sharing',
                'is_free' => true,
                'price' => 0.00,
            ],
            [
                'name' => 'ChatGPT',
                'description' => 'Learn about ChatGPT.',
                'img' => $defaultImagePath,
                'course_category_id' => 2, // Learning
                'gdrive_link' => 'https://drive.google.com/drive/folders/1ZFMGFbjyzgRl5p-lMMJegNl0xzkjuwpt?usp=sharing',
                'is_free' => false,
                'price' => 99.00,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Automotive learning resources.',
                'img' => $defaultImagePath,
                'course_category_id' => 2, // Learning
                'gdrive_link' => 'https://drive.google.com/drive/folders/1nxyM1GADvTrm-q0N9ZBlCrjwmoVxDvvk?usp=sharing',
                'is_free' => false,
                'price' => 99.99,
            ],
            [
                'name' => 'Programming',
                'description' => 'Programming tutorials and resources.',
                'img' => $defaultImagePath,
                'course_category_id' => 2, // Learning
                'gdrive_link' => 'https://drive.google.com/drive/folders/1EdDtGoFXG7ZYMcqW80L4BWMqdFJxbggU?usp=sharing',
                'is_free' => false,
                'price' => 99.99,
            ],
            [
                'name' => 'Powerpoint Templates',
                'description' => 'Powerpoint templates for business.',
                'img' => $defaultImagePath,
                'course_category_id' => 3, // Business & Templates
                'gdrive_link' => 'https://drive.google.com/drive/folders/1Su7POcnX47Bnh43-kRnm7NY2ZcbEhKd8?usp=sharing',
                'is_free' => false,
                'price' => 99.99,
            ],
            [
                'name' => 'Sales & Inventory',
                'description' => 'Sales and inventory templates.',
                'img' => $defaultImagePath,
                'course_category_id' => 3, // Business & Templates
                'gdrive_link' => 'https://drive.google.com/drive/folders/1YYdzYH-5ThApQY7xD0OokSaCfd6RT5R8?usp=sharing',
                'is_free' => false,
                'price' => 99.99,
            ],
            [
                'name' => 'DIY Negosyo',
                'description' => 'DIY business guides.',
                'img' => $defaultImagePath,
                'course_category_id' => 3, // Business & Templates
                'gdrive_link' => 'https://drive.google.com/drive/folders/1VPBFjJ2NiS6hmASV60vn2JhQ-iojjgnj?usp=sharing',
                'is_free' => false,
                'price' => 99.99,
            ],
        ];

        foreach ($courses as $course) {
            DB::table('courses')->insert(array_merge($course, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
