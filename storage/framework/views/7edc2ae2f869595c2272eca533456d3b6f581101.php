
<?php
    if(isset($content)){
        $content = json_decode($question->content);
    }
    $width = $height = '';
    isset($content[0]->width) ? $width = $content[0]->width : '';
    isset($content[0]->height) ? $height = $content[0]->height : '';
?>
<div id="euro_part" class="question-box" <?php if(isset($display)): ?> style="display:<?php echo e($display); ?>;" <?php endif; ?>>
    <?php
        if(isset($question)) 
        {
            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);
            echo Form::color('color1', $question->color1 ? $question->color1 : $current_tests[0]->color1, ['class' => 'form-control ', 'name'=>'color1']);
            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);
            echo Form::color('color2', $question->color2 ? $question->color2 : $current_tests[0]->color2, ['class' => 'form-control ', 'name'=>'color2']);
        }
        else {
            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);
            echo Form::color('color1', '', ['class' => 'form-control ', 'name'=>'color1']);
            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);
            echo Form::color('color2', '', ['class' => 'form-control ', 'name'=>'color2']);
        }
    ?>
    <div class="form-group">
        <input type="text" id="euro_input_width" class="form-control " placeholder="Width" value='<?php echo e($width); ?>'>
    </div>
    <div class="form-group">
        <input type="text" id="euro_input_height" class="form-control " placeholder="Height" value='<?php echo e($height); ?>'>
    </div>
</div>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/questions/components/simple/euro.blade.php ENDPATH**/ ?>