<?php $__env->startSection('title', 'ByteLearn - Learn Smarter, Not Harder'); ?>

<?php $__env->startSection('scripts'); ?>
<?php
    $userData = auth()->user() ? [
        'id' => auth()->user()->id,
        'name' => auth()->user()->name,
        'email' => auth()->user()->email,
        'role' => auth()->user()->role
    ] : null;
?>
<script>
    // Override initial data for homepage
    document.getElementById('app-data').textContent = JSON.stringify({
        page: 'home',
        user: <?php echo json_encode($userData, 15, 512) ?>
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Documents\GitHub\471-project\Bytelearn\resources\views/welcome.blade.php ENDPATH**/ ?>