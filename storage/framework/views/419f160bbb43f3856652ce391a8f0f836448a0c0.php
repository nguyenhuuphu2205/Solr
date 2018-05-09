<html>
<head>
    <base href="<?php echo e(asset('/')); ?>">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <title>Tìm kiếm</title>
    <link rel="shortcut icon" href="search.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

    <!------ Include the above in your HEAD tag ---------->
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
            <div class="row google-logo text-center">
                <img src="logo_solr.png" alt="logo" class="" style="height: 150px;">
            </div>
            <div class="row google-form text-center">
                <form action="search" method="get">
                    <div class="form-group">


                        <input type="text" class="form-control google-search" name="q" list="suggestions" required id="google_input" placeholder="Nhập nội dung tìm kiếm"
                               <?php if(isset($q)): ?>
                               value="<?php echo e($q); ?>"
                                <?php endif; ?>
                        >
                        <datalist id="suggestions">
                        <?php $__currentLoopData = $tukhoa_suggest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sg->tukhoa); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </datalist>
                        <div class="btn-group">
                            <br>
                            <button type="submit" class="btn btn-default">Tìm kiếm</button>
                            <a type="button" target="_blank" class="btn btn-default" onclick="googleSearch()" id="gg">Tìm kiếm với google</a>
                        </div>
                    </div>
                </form>

            </div>


        </div>
    </div>
</div>
<?php echo $__env->yieldContent('content'); ?>
</body>
</html>