<?php $__env->startSection('title', 'Student Dashboard - ByteLearn'); ?>

<?php $__env->startSection('scripts'); ?>
<?php
    $currentUser = $student ?? auth()->user();
    $userData = [
        'id' => $currentUser->id,
        'name' => $currentUser->name,
        'email' => $currentUser->email,
        'role' => 'student',
        'location' => $currentUser->locationRecord->location_string ?? $currentUser->location,
        'lat' => $currentUser->locationRecord->latitude ?? null,
        'lon' => $currentUser->locationRecord->longitude ?? null,
        'share_email' => $currentUser->locationRecord->share_email ?? true,
    ];

    $enrolledCoursesData = $enrolledCourses->map(function($enrollment) use ($courseProgress) {
        return [
            'id' => $enrollment->course->id,
            'title' => $enrollment->course->title,
            'instructor' => $enrollment->course->instructor->name ?? 'Instructor',
            'image' => 'https://images.unsplash.com/photo-1557324232-b8917d3c3dcb?w=600',
            'continueUrl' => route('student.continue-learning', ['courseId' => $enrollment->course->id]),
            'progress' => $courseProgress[$enrollment->course->id] ?? 0,
            'currentLesson' => 'Continue Learning',
            'totalLessons' => $enrollment->course->lessons->count(),
            'completedLessons' => round(($courseProgress[$enrollment->course->id] ?? 0) * $enrollment->course->lessons->count() / 100),
            'nextQuiz' => null,
            'lastAccessed' => ($enrollment->updated_at ?? $enrollment->enrollment_date ?? now())->diffForHumans()
        ];
    });

    $notificationsData = $notifications->map(function($notification) {
        return [
            'id' => $notification->id,
            'type' => 'info',
            'message' => $notification->message,
            'time' => $notification->created_at->diffForHumans(),
            'unread' => $notification->read_at === null
        ];
    });
?>
<script>
    // Pass Laravel data to React
    document.getElementById('app-data').textContent = JSON.stringify({
        page: 'student-dashboard',
        user: <?php echo json_encode($userData, 15, 512) ?>,
        dashboardData: {
            enrolledCourses: <?php echo json_encode($enrolledCoursesData, 15, 512) ?>,
            completedCourses: <?php echo json_encode($completedCoursesData, 15, 512) ?>,
            notifications: <?php echo json_encode($notificationsData, 15, 512) ?>,
            privateNotes: <?php echo json_encode($privateNotes, 15, 512) ?>,
            enrolledLessions: <?php echo json_encode($enrolledLessions, 15, 512) ?>,
            recentDiscussions: <?php echo json_encode($recentDiscussions, 15, 512) ?>,
            nearbyStudents: <?php echo json_encode($nearbyStudents, 15, 512) ?>,
            stats: {
                'ongoingCourses': <?php echo e($ongoingCourses); ?>,
                'completedCourses': <?php echo e($completedCourses); ?>,
                'learningStreak': <?php echo e($learningStreak); ?>,
                'certificatesEarned': <?php echo e($certificatesEarned); ?>

            },
            courseProgress: <?php echo json_encode($courseProgress, 15, 512) ?>,
            leaderboard: <?php echo json_encode($leaderboard, 15, 512) ?>,
            currentUserPoints: <?php echo e($currentUserPoints); ?>

        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI\Documents\GitHub\Bytelearn\resources\views/student/dashboard.blade.php ENDPATH**/ ?>