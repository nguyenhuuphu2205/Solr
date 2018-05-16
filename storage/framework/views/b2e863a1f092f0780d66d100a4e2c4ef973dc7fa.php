<?php $__env->startSection('content'); ?>
    <div class="container">
<?php if(isset($number)): ?>
    <div class="col-xs-12 " >
    <?php
    if($page==1){

        echo "<h4 >$number kết quả được tìm thấy trong $time s</h4>";
    }

    ?>
    </div>
<?php endif; ?>
    <?php if(isset($spell) and $spell !=null and isset($page) and $page==1): ?>
        <div class="col-xs-12 " style="margin-bottom:20px;">
            <p><span class="search-title" style="font-size: 18px;color: #000000">Hiển thị kết quả cho <a href="<?php echo e(route('search',['q'=>$spell])); ?>" style="color: #1a0dab"><?php echo e($spell); ?></a></span>
            <br>
            <span class="search-title" style="font-size: 14px;color: #000000">
                Tìm kiếm thay thế cho <a href="#" style="color: #1a0dab"><?php echo e($q); ?></a>
            </span>
            </p>
        </div>
    <?php endif; ?>
<?php if(count($errors)>0): ?>
    <div class="alert-danger">
        <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
    <?php $__currentLoopData = $tintuc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-xs-12 " style="margin-bottom:20px;" >
        <a href="<?php echo e($tt->url); ?>">   <span class="search-title" style="font-size: 18px;color: #1a0dab">
                
                <?php
                if(isset($q)){
                $title_highlight=str_replace($q,'<b>'.$q.'</b>',$tt->title);
                $title_highlight=str_replace(strtolower($q),'<b>'.strtolower($q).'</b>',$title_highlight);
                $title_highlight=str_replace(strtoupper($q),'<b>'.strtoupper($q).'</b>',$title_highlight);
                echo $title_highlight;
                }else{
                    //echo $tt->title;
                }
                ?>
            </span></a><br>
        <span class="search-link">
            <div class="btn-group">
      <i  class="fa fa-caret-down dropdown-toggle "  data-toggle="dropdown" aria-hidden="true"></i>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo e($tt->url); ?>">Xem chi tiết</a></li>
          </ul><span style="font-size: 14px;color: #006621"><?php echo e(substr($tt->url,0,60)); ?>...</span>
        </div>
        </span>
        <div style="width: 1200px; height: 157px; overflow: auto;">
        <span class="search-para" >
            <?php
            if(isset($q)){


            $content_highlight=str_replace($q,'<b>'.$q.'</b>',$tt->content);
            $content_highlight=str_replace(strtolower($q),'<b>'.strtolower($q).'</b>',$content_highlight);
            $content_highlight=str_replace(strtoupper($q),'<b>'.strtoupper($q).'</b>',$content_highlight);
            echo $content_highlight;
            }else{
                echo $tt->content;
            }
            ?>
        </span></div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $tintuc->links(); ?>


</div>

</div>
<script>
    function googleSearch(){
        input=document.getElementById('google_input').value;

        document.getElementById('gg').setAttribute('href','https://www.google.com/search?q='+input);
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>