<?php if(!empty($content)): ?>
<style>
    .change-img-bg-color{
        background: rgba(20,6,62,1);
    }
</style>
<div class="d-flex p-0 image_content" style="flex-direction:column; gap: .5rem;">
    <?php if(isset($content) && data_get($content, '0.image')): ?>
        <?php $__currentLoopData = $content[0]->image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="
                <?php echo e(isset($content[(sizeof($content)-1)]->col)?$content[(sizeof($content)-1)]->col:''); ?> mt-2
                d-flex align-items-center
            " style="gap: 2rem;">
                <div class="form-group m-0">
                    <img
                        src="<?php echo e(asset('uploads/image/')); ?><?php echo e('/'.$c); ?>"
                        onclick="clickimg(this)"
                        class="img-thumbnail"
                        alt="image<?php echo e($key); ?>"
                        width="100px"
                        height="100px"
                        srcset=""
                    />

                    <input
                        type="radio"
                        style="display:none"
                        name="imgradiogroup"
                        data-key="<?php echo e($key+1); ?>"
                        id="<?php echo e($question->id); ?>"
                        class="form-check-input <?php echo e(' imagebox_'.$key); ?>"
                        value="<?php echo e(data_get($content, [0, 'score', $key])); ?>"
                        data-score="<?php echo e(data_get($content, [0, 'score', $key])); ?>"
                    />
                </div>

                <?php if($description = data_get($content, [0, 'description', $key])): ?>
                    <div>
                        <?php echo e($description); ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php $__env->startPush('after-scripts'); ?>
    <script>
        function clickimg(ele){
            if($('#percent').val() == 1000  && $('#reported').val() == 10){
                alert('You can not edit your answers!');
            }else {
                $('.change-img-bg-color').each(function(){
                    $(this).removeClass('change-img-bg-color');
                });

                $(ele).addClass('change-img-bg-color');
                $(ele).next().prop("checked", true);
            }
        }
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/image.blade.php ENDPATH**/ ?>