<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\CoursePayment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $courseId = null)
    {
        $user = $request->user();

        $selectedCourse = $courseId ? Course::find($courseId) : null;

        // Get all courses that are not free and have not been bought by the user with verified payments
        $courses = Course::where('is_free', false)
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('course_id')
                    ->from('course_payments')
                    ->join('payments', 'course_payments.payment_id', '=', 'payments.id')
                    ->where('payments.user_id', $user->id)
                    ->where('payments.verified', true); // Ensure only verified payments are considered
            })->get();

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
     * Handle payments
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'additional_course_ids' => 'nullable|array',
            'additional_course_ids.*' => 'exists:courses,id',
            'payment_amount' => 'required|numeric|min:0',
            'reference_number' => 'nullable|string|unique:payments,reference_number',
            'screenshot' => 'nullable|file|mimes:jpg,png,jpeg|max:2048', // max 2MB
        ]);

        $user = $request->user();

        // Save payment details
        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->amount = $validated['payment_amount'];
        $payment->reference_number = $validated['reference_number'] ?? null;
        $payment->payment_date = now(); // Assuming payment date is the current time
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('gcash_screenshots', 'public');
            $payment->gcash_screenshot = $screenshotPath;
        }
        $payment->save();

        // Save the courses associated with this payment
        $courseIds = array_merge(
            [$validated['course_id']],
            $validated['additional_course_ids'] ?? []
        );

        foreach ($courseIds as $courseId) {
            CoursePayment::create([
                'payment_id' => $payment->id,
                'course_id' => $courseId,
            ]);
        }

        // Send email notification to admin
        // try {
        //     Mail::to('reancirl@gmail.com')->send(new PaymentNotification($payment, $courseIds, $user));
        // } catch (\Exception $e) {
        //     // Log email sending error
        //     \Log::error('Failed to send payment notification email: ' . $e->getMessage());
        // }

        return redirect()->route('payment.index')->with('success', 'Transaction submitted successfully.');
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
