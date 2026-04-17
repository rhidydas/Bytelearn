<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'ByteLearn - Peer-Led Micro Learning Platform'); ?></title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Leaflet Map API -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Vite enabled -->
<?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.tsx']); ?>

<?php echo $__env->yieldContent('styles'); ?>

</head>

<body>

<!-- React App Mount Point -->
<div id="app"></div>

<!-- Blade Content -->
<?php echo $__env->yieldContent('content'); ?>

<!-- Initial Data from Laravel -->
<script id="app-data" type="application/json">
    <?php echo json_encode($data ?? $reactData ?? ['page' => 'home', 'user' => null], 512) ?>
</script>

<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\Users\User\Desktop\Bytelearn\resources\views/layouts/app.blade.php ENDPATH**/ ?>