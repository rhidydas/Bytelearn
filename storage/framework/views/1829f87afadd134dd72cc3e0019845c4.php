<?php $__env->startSection('title', 'Register - ByteLearn'); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Override initial data for register page
    document.getElementById('app-data').textContent = JSON.stringify({
        page: 'register',
        user: null,
        errors: <?php echo json_encode($errors->all(), 15, 512) ?>,
        old: <?php echo json_encode(session()->getOldInput(), 15, 512) ?>
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI\Documents\GitHub\Bytelearn\resources\views/auth/register.blade.php ENDPATH**/ ?>