<?php

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

if(isset($firstFontSize1)){
    $firstFontSize1 = $firstFontSize1;
}else{
    $firstFontSize1 = '';
}

if(isset($firstStyle1)){
    $firstStyle1 = $firstStyle1;
}else{
    $firstStyle1 = '';
}

if(isset($firstFamily1)){
    $firstFamily1 = $firstFamily1;
}else{
    $firstFamily1 = '';
}

?>
<div class='rating-box rating_content w-100'  data-required="<?php if($question->required=="1"): ?> 1 <?php else: ?> 0 <?php endif; ?>" >
    <ul 
        id='rating-list<?php echo e($question->id); ?>' 
        style="justify-content: <?php echo e(data_get($question, 'answer_aligment', 'left')); ?>;"
        class="rate-list w-100"
    >
        <?php
            $i=1;
            $color = $question->color1;
            if (is_array($content)) {
                foreach($content as $c){
                    if(isset($c->col)) $col = $c->col;
                }
            }
        ?>

        <?php if($content != ''): ?>
            <?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($c->label)): ?>
                    <div class="rate-item">
                        <li class='rate' id='rate<?php echo e($i); ?>' onclick='changeRating(<?php echo e($i); ?>)' data-q_id="<?php echo e($question->id); ?>" name="rating" style="--active-color:<?php if($question->color2 != ""){ echo $question->color2;  }else{ echo "black";}  ?>;color: var(--active-color);font-size:<?php echo e($firstFontSize); ?>;font-style:<?php echo e($firstStyle); ?>;font-family:<?php echo e($firstFamily); ?>;" title="<?php echo e($c->score); ?>" data-value='<?php echo e($i); ?>' data-score="<?php echo e($c->score); ?>">
                            <?php echo e($c->label); ?>

                        </li>
                    </div>
                <?php elseif(isset($c->color)): ?>
                    <?php
                        $color = $question->color1;
                    ?>
                <?php endif; ?>
                <?php
                    $i++;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>

    <input type="hidden" name="star_color" class="star_color" value="<?php echo e($color); ?>">
    <input type="hidden" class="ratinginput" name="b_rating" id="scoreNow<?php echo e($question->id); ?>" data-qid="<?php echo e($question->id); ?>" value="0" data-selected="false">
    <span class="message mt-2"></span>
</div>
<script>
function changeRating(boxid){
    var text1 = "<?php echo $firstFontSize1 ?>";
    var text2 = "<?php echo $firstFontSize ?>";
    // $(".rate").css('font-size',''+text2+'');
    // $("#rate"+boxid).css('font-size',''+text1+'');
}


</script><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/rating.blade.php ENDPATH**/ ?>