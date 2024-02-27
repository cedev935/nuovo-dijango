<div class="mb-2">
    <div class="checkbox-input" data-required="<?php if($question->required=="1"): ?> 1 <?php else: ?> 0 <?php endif; ?>">
        <?php
            $temp_val =1;
            $content = json_decode($question->content);

if ($content !== null) {
    foreach ($content as $key => $c) {
        if (isset($c->col)) {
            $col = $c->col;
        }
    }
}
if(isset($firstFontSize)){
    $firstFontSize = $firstFontSize;
}else{
    $firstFontSize = '';
}

if(isset($firstStyle)){
    $firstStyle = $firstStyle;
}else{
    $firstStyle = '';
}

if(isset($firstFamily)){
    $firstFamily = $firstFamily;
}else{
    $firstFamily = '';
}
            
        ?>
        <div class="row p-0 check_content">
        <?php if($content !== null): ?>
            <?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($c->label)): ?>
                <div class="p-0">
                    <div class="form-check p-0">
                        <div class="square-check checkbox gradient-bg" style='--active-color: <?php echo e($question->color1); ?> !important; --inactive-color: <?php echo e($question->color2); ?> !important;' >
                            <input class="form-check-input <?php echo e(' checkbox_'.$key); ?>" name="checkbox-radio" type="checkbox" data-qid="<?php echo e($question->id); ?>" data-key="<?php echo e($key+1); ?>" value="<?php echo e($c->score); ?>" <?php echo e((isset($identy[$question->id]))?($identy[$question->id]==$c->score)?'data-opendiv='.$ids[$question->id]:'':''); ?> name="flexRadioDefault"  id="<?php echo e($question->id); ?>">
                            <?php echo e($c->label); ?>

                            <div class="square-check--content"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php
                    $temp_val++;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
    <span class="message mt-2"></span>
</div><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/checkbox.blade.php ENDPATH**/ ?>