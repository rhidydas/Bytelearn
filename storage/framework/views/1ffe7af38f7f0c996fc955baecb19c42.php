<?php $__env->startSection('title', 'My Courses - ByteLearn'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-baseline justify-between gap-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-900">My Enrolled Courses</h1>
        <a href="<?php echo e(route('courses.index')); ?>" class="text-blue-600 hover:text-blue-700 font-medium">Browse all courses</a>
    </div>

    <?php if($enrolledCourses->count() === 0): ?>
        <div class="bg-white border border-gray-200 rounded-xl p-8 text-center text-gray-600">
            <p class="text-lg">You’re not enrolled in any courses yet.</p>
            <p class="mt-2">Go to the catalog to find something to learn.</p>
        </div>
    <?php else: ?>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Enrolled</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $enrolledCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900"><?php echo e($enrollment->course->title ?? 'Course'); ?></div>
                                    <div class="text-sm text-gray-600">Instructor: <?php echo e($enrollment->course->instructor->name ?? 'Instructor'); ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <?php echo e(optional($enrollment->created_at)->format('M d, Y') ?? '—'); ?>

                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a
                                            href="<?php echo e(route('courses.show', $enrollment->course_id)); ?>"
                                            class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                                        >
                                            Details
                                        </a>
                                        <a
                                            href="<?php echo e(route('student.continue-learning', $enrollment->course_id)); ?>"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                        >
                                            Continue
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
            <?php echo e($enrolledCourses->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\Bytelearn\resources\views/student/courses.blade.php ENDPATH**/ ?>