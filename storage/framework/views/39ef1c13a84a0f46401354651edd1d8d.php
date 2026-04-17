<?php $__env->startSection('title', 'Completed Courses - ByteLearn'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-baseline justify-between gap-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Completed Courses</h1>
        <a href="<?php echo e(route('student.dashboard')); ?>" class="text-blue-600 hover:text-blue-700 font-medium">Back to dashboard</a>
    </div>

    <?php if($completedCourses->count() === 0): ?>
        <div class="bg-white border border-gray-200 rounded-xl p-8 text-center text-gray-600">
            <p class="text-lg">No completed courses yet.</p>
            <p class="mt-2">Finish a course to earn a certificate.</p>
        </div>
    <?php else: ?>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Completed</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $completedCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900"><?php echo e($certificate->course->title ?? 'Course'); ?></div>
                                    <div class="text-sm text-gray-600">Instructor: <?php echo e($certificate->course->instructor->name ?? 'Instructor'); ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <?php echo e(optional($certificate->created_at)->format('M d, Y') ?? '—'); ?>

                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a
                                            href="<?php echo e(route('courses.show', $certificate->course_id)); ?>"
                                            class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                                        >
                                            Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <?php echo e($completedCourses->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Documents\GitHub\Bytelearn\resources\views/student/completed-courses.blade.php ENDPATH**/ ?>