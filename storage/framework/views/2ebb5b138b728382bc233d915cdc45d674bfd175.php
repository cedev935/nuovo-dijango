
<div id="dropdown_part" class="row question-box" <?php if(isset($display)): ?> style="display:<?php echo e($display); ?>;" <?php endif; ?>>
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
    <div class="col-12">
        <a id="dropdown_add" class="btn btn-success" style="color:white; margin-top:10px;">+ New</a>
    </div>
    <div class="col-12  form-group " id="sortable_drop">
    <!-- <form> -->
        <?php if(isset($content)): ?>
            <?php
                $radioContent = json_decode($content);
            ?>
            <?php $__currentLoopData = $radioContent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($c->label)): ?>
                    <div class="radio">
                    <label  style="color:transparent"><input type="radio" name="opt_drop" <?php if(isset($c->is_checked)): ?><?php echo e(($c->is_checked==1) ? 'checked' : ''); ?><?php endif; ?>>Option 1</label>
                        <input class="radio_label" type="text" value="<?php echo e($c->label); ?>" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                        <label  >Score</label>
                        <input  class ="radio_score" type="text"   value="<?php echo e($c->score); ?>" style="margin-right:1vw">
                        <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                            <i class="fa fa-trash" style="color:white"></i>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="radio" checked>Option</label>
                <input class="radio_label" type="text" value="1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                <label  >Score</label>
                <input  class ="radio_score" type="text"   value="" style="margin-right:1vw">
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="radio" >Option</label>
                <input class="radio_label" type="text" value="2" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                <label  >Score</label>
                <input  class ="radio_score" type="text"   value="" style="margin-right:1vw">
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="42">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/questions/components/simple/dropdown.blade.php ENDPATH**/ ?>