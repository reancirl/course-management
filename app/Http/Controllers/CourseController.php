<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource based on the category.
     */
    public function index($category)
    {
        // Map category slugs to IDs and views
        $categories = [
            'learning' => [
                'id' => 2,
                'view' => 'Course',
            ],
            'business-and-templates' => [
                'id' => 3,
                'view' => 'Course',
            ],
            'freebies' => [
                'id' => 1,
                'view' => 'Course',
            ],
        ];

        if (!array_key_exists($category, $categories)) {
            abort(404, 'Category not found.');
        }

        $courses = Course::where('course_category_id', $categories[$category]['id'])->get();

        // Fetch the IDs of courses the user has already bought
        $userBoughtCourses = auth()->user()
            ? auth()->user()->payments()->with('courses')->get()->pluck('courses.*.id')->flatten()->toArray()
            : []; // Empty array if user is not authenticated

        return Inertia::render($categories[$category]['view'], [
            'courses' => $courses,
            'title' => ucfirst(str_replace('-', ' ', $category)),
            'userBoughtCourses' => $userBoughtCourses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
