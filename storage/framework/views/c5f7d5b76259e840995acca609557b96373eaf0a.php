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
<div class="mb-2 dropdowninput" data-required="<?php if($question->required=="1"): ?> 1 <?php else: ?> 0 <?php endif; ?>">

    <div class="form-group">
        <label 
            for=""
            style="
                color: <?php echo e($question->color2); ?>;
                font-size: <?php echo e($firstFontSize); ?>;
                font-style: <?php echo e($firstStyle); ?>;
                font-family: <?php echo e($firstFamily); ?>;
                padding: 0 !important;
            "
        >
            Select Value
        </label>
        
        <select 
            class="form-control dropdown"
            name="dropdown"
            id="<?php echo e($question->id); ?>"
            style="
                width: fit-content;
                height: auto !important;
                color: <?php echo e($question->color2); ?>;
                border-color: <?php echo e($question->color2); ?>;
                font-size: <?php echo e($firstFontSize); ?>;
                font-style: <?php echo e($firstStyle); ?>;
                font-family: <?php echo e($firstFamily); ?>;
            "
        >
            <option value="">Select Option</option>
          
            <?php if(isset($content) && (is_array($content) || $content instanceof Countable)): ?>
                <?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key != (sizeof($content) - 1)): ?>
                        <?php if(isset($c->label)): ?>
                            <option id="opt" data-key="<?php echo e($key + 1); ?>" value="<?php echo e($c->score); ?>"><?php echo e($c->label); ?></option>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </select>
  </div>
  <span class="message mt-2"></span>
</div>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/dropdown.blade.php ENDPATH**/ ?>