<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <title>Project</title>
</head>
<body class="d-flex flex-column h-100 bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a href="<?php echo e(route('faker.index')); ?>" class="navbar-brand">
                <i class="fa fa-globe"></i>
                <span>Project</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="<?php echo e(route('faker.index')); ?>" class="nav-link" style="color:#fff;">
                            <i class="fa fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('faker.index')); ?>" class="nav-link" style="color:#fff;">
                            <i class="fa fa-info-circle"></i>
                            <span>About</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(config('site.discord_url')); ?>" class="nav-link" style="color:#fff;" target="_blank">
                            <i class="fa fa-comments"></i>
                            <span>Discord Server</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-shrink-0">
        <div class="container mt-4">
            <?php if(count($errors) > 0): ?>
                <div class="alert bg-danger text-white">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo $error; ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-success text-white">
        <div class="container">
            <p>This website is not affiliated, endorsed, and/or sponsored by any companies, trademarks, or copyrighted names mentioned. No copyright infringement is intended.</p>
            <p class="mb-0">©2022 <?php echo e(request()->getHost()); ?></p>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/faker.blade.php ENDPATH**/ ?>