<div class='rating-stars stars_content' data-required="<?php if($question->required=="1"): ?> 1 <?php else: ?> 0 <?php endif; ?>">
    <?php
        $len = 0;
        // $content = json_decode($question->content, true);
        
        if(filled($content)){
            foreach($content as $c){
                if(isset($c->label))
                $len++;
            }
        }
    ?>

    <ul id='stars<?php echo e($question->id); ?>'>
        <?php for($i = 0; $i < $len; $i++): ?>
            <li class='<?php echo e('star star-'.($i+1)); ?>' name="star" data-value='<?php echo e($i+1); ?>' style="color: <?php echo e($question->color2); ?>;">
                <i class='fas fa-star fa-fw' style="font-size: 30px;"></i>
            </li>
        <?php endfor; ?>
    </ul>
    <?php
        $i=1;
        $color = "#fff";
    ?>
    <?php if(isset($content) && (is_array($content) || $content instanceof Countable)): ?>
    <?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(isset($c->color)): ?>
            <?php
                $color = $c->color;
            ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <input type="hidden" name="star_color" class="star_color" value="<?php echo e($color); ?>">
    <input type="hidden" class="starinput" id="<?php echo e($question->id); ?>" data-qid="<?php echo e($question->id); ?>" value="0" data-selected="false">
    <span class="message mt-2"></span>
</div><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/stars.blade.php ENDPATH**/ ?>