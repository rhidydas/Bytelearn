<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Enroll student in course
     */
    public function store(Request $request, $courseId)
    {
        $student = Auth::user();
        $course = Course::where('status', 'published')->findOrFail($courseId);

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $student->id)
                                        ->where('course_id', $courseId)
                                        ->first();

        if ($existingEnrollment) {
            if ($request->wantsJson() || $request->is('api/*')) {
                 return response()->json(['message' => 'Already enrolled'], 200);
            }
            return back()->with('info', 'Already enrolled in this course');
        }

        // Create enrollment
        Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $courseId,
            'enrollment_date' => now(),
            'progress' => 0,
        ]);

        if ($request->wantsJson() || $request->is('api/*')) {
             return response()->json(['message' => 'Successfully enrolled'], 201);
        }

        return redirect()->route('student.dashboard')
                       ->with('success', 'Successfully enrolled in course!');
    }

    /**
     * Unenroll from course
     */
    public function destroy($enrollmentId)
    {
        $student = Auth::user();
        $enrollment = Enrollment::findOrFail($enrollmentId);

        if ($enrollment->user_id !== $student->id) {
            abort(403, 'Unauthorized');
        }

        $enrollment->delete();

        return back()->with('success', 'Unenrolled from course successfully!');
    }
    /**
     * Update progress
     */
    public function updateProgress(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $student = Auth::user();
        
        $enrollment = Enrollment::where('user_id', $student->id)
                                ->where('course_id', $request->course_id)
                                ->first();

        if ($enrollment) {
            $enrollment->progress = $request->progress;
            $enrollment->save();
            
            // Update learning streak for consecutive day tracking
            $student->updateLearningStreak();
            
            return response()->json(['message' => 'Progress updated', 'progress' => $enrollment->progress]);
        }

        return response()->json(['message' => 'Enrollment not found'], 404);
    }
}
