
<div id="checkbox_part" class="question-box" <?php if(isset($display)): ?> style="display:<?php echo e($display); ?>;" <?php endif; ?>>
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

        <a id="check_add" class="btn btn-success mb-2" style="color:white; margin-top:10px;">+ New</a>
    </div>
    <div class="col-12">
        <label for="">Select Display</label>
        <?php if(isset($content)): ?>
           <?php
               $con = json_decode($content);
               foreach($con as $key => $c){
                   if(isset($c->display)){
                       $display = $c->display;
                   }
               }
           ?>
       <?php endif; ?>
        <?php $disp_len = 4; $max = 12; ?>
        <select name="display_checkbox" class="form-control" id="display_checkbox">
            <?php for($i = 1; $i <= $disp_len; $i++): ?>
               <option value="<?php echo e('col-'.$max/$i); ?>" <?php if(isset($display)): ?><?php if($i == $display): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($i); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div id="sortable-10" class="col-12 form-group">
        <?php if(isset($content)): ?>
            <?php
                $radioContent = json_decode($content);
            ?>
            <?php $__currentLoopData = $radioContent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($c->label)): ?>
                <div  class="checkbox">
                    <label style="color:transparent">
                    <input type="checkbox"   class="check_box_q" <?php if(isset($c->is_checked)): ?><?php echo e(($c->is_checked==1) ? 'checked' : ''); ?><?php endif; ?>>Option 1
                    </label>
                    <input class="check_label" type="text" value="<?php echo e($c->label); ?>" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
                    <label >Score</label>
                    <input type="text"  class="checkbox_score"  value="<?php echo e($c->score); ?>" style="margin-right:1vw">
                    
                    <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                        <i class="fa fa-trash" style="color:white"></i>
                            <?php echo e(method_field('DELETE')); ?>

                    </a>
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div  class="checkbox">
                <label style="color:transparent">
                    <input type="checkbox" class="check_box_q">Option 1
                </label>
                <input class="check_label" type="text" value="Check1" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
                <label >Score</label>
                <input type="text"  class="checkbox_score"  value="0" style="margin-right:1vw">
                
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                    <i class="fa fa-trash" style="color:white"></i>
                        <?php echo e(method_field('DELETE')); ?>

                </a>
            </div>
            <div class="checkbox">
                <label  style="color:transparent"><input type="checkbox" class="check_box_q" value="">Option 1 </label>  
                <input class="check_label" type="text" value="Check1" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
                <label>Score</label>
                <input type="text" class="checkbox_score"  value="0" style="margin-right:1vw">
            
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="12">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/questions/components/simple/checkbox.blade.php ENDPATH**/ ?>