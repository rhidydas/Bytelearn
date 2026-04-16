<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Complete a course - mark as done, generate certificate, send notification
     */
    public function completeCourse($courseId)
    {
        $student = Auth::user();
        $course = Course::findOrFail($courseId);

        // Check enrollment
        $enrollment = Enrollment::where('user_id', $student->id)
                                ->where('course_id', $courseId)
                                ->first();

        if (!$enrollment) {
            return back()->with('error', 'You are not enrolled in this course.');
        }

        // Mark as 100% complete
        $enrollment->progress = 100;
        $enrollment->save();

        // Check if certificate already exists
        $existingCertificate = Certificate::where('user_id', $student->id)
                                          ->where('course_id', $courseId)
                                          ->first();

        if (!$existingCertificate) {
            // Create certificate
            $certificate = Certificate::create([
                'user_id' => $student->id,
                'course_id' => $courseId,
                'verification_code' => $this->generateVerificationCode(),
                'issue_date' => now(),
            ]);

            // Create notification
            Notification::create([
                'user_id' => $student->id,
                'title' => 'Certificate Earned!',
                'message' => "Congratulations! You received a certificate for successfully completing the \"{$course->title}\" course.",
                'type' => 'success',
            ]);
        }

        return redirect()->route('student.dashboard')
                       ->with('success', "Congratulations! You've completed \"{$course->title}\" and earned a certificate!");
    }

    /**
     * Generate certificate for completed course
     */
    public function generate($courseId)
    {
        $student = Auth::user();
        $course = Course::findOrFail($courseId);

        // Check if course is completed
        $enrollment = $course->enrollments()->where('user_id', $student->id)->first();

        if (!$enrollment || !$enrollment->isCompleted()) {
            return back()->with('error', 'Course not yet completed');
        }

        // Check if certificate already exists
        $existingCertificate = Certificate::where('user_id', $student->id)
                                          ->where('course_id', $courseId)
                                          ->first();

        if ($existingCertificate) {
            return response()->download(storage_path('certificates/' . $existingCertificate->id . '.pdf'));
        }

        // Create certificate
        $certificate = Certificate::create([
            'user_id' => $student->id,
            'course_id' => $courseId,
            'verification_code' => $this->generateVerificationCode(),
            'issue_date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'certificate_id' => $certificate->id,
            'verification_code' => $certificate->verification_code,
        ]);
    }

    /**
     * Download certificate
     */
    public function download($certificateId)
    {
        $student = Auth::user();
        $certificate = Certificate::findOrFail($certificateId);

        if ($certificate->user_id !== $student->id) {
            abort(403, 'Unauthorized');
        }

        // In a real app, this would generate/download a PDF
        return response()->json([
            'certificate_number' => $certificate->verification_code,
            'user' => $certificate->user->name,
            'course' => $certificate->course->title,
            'issue_date' => $certificate->issue_date->format('F j, Y'),
        ]);
    }

    /**
     * Generate unique verification code
     */
    private function generateVerificationCode()
    {
        return strtoupper('CERT-' . date('YmdHis') . '-' . strtoupper(uniqid()));
    }

    /**
     * Show all certificates for student
     */
    public function index()
    {
        $student = Auth::user();
        $certificates = $student->certificates()->with('course')->get();

        $certificatesData = $certificates->map(function($cert) {
            return [
                'id' => $cert->id,
                'courseTitle' => $cert->course->title,
                'courseId' => $cert->course_id,
                'studentName' => $cert->user->name,
                'verificationCode' => $cert->verification_code,
                'issueDate' => $cert->issue_date->format('F j, Y'),
                'issueDateRaw' => $cert->issue_date->toISOString(),
            ];
        });

        return view('student.certificates', [
            'data' => [
                'page' => 'certificates',
                'user' => [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'role' => $student->role,
                ],
                'certificates' => $certificatesData,
            ]
        ]);
    }
}
