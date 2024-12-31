<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $courseId = null)
    {
        // Get the selected course if courseId is provided
        $selectedCourse = $courseId ? Course::find($courseId) : Course::find(5);

        // Get all courses for the dropdown
        $courses = Course::where('is_free',false)->get();

        return Inertia::render('Transaction', [
            'selectedCourse' => $selectedCourse,
            'courses' => $courses,
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
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
