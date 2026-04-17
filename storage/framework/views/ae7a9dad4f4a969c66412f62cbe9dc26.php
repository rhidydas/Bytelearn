<?php $__env->startSection('title', 'Login - ByteLearn'); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Override initial data for login page
    document.getElementById('app-data').textContent = JSON.stringify({
        page: 'login',
        user: null,
        error: <?php echo json_encode($errors->first('email') ?: $errors->first('password') ?: ''); ?>

    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Documents\GitHub\Bytelearn\resources\views/auth/login.blade.php ENDPATH**/ ?>