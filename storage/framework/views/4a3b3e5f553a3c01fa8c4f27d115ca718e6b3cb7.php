
<div id="radiogroup" class="row question-box" <?php if(isset($display)): ?> style="display:<?php echo e($display); ?>;" <?php endif; ?>>
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
        <a id="radio_add" href="javascript:void(0);" class="btn btn-success">+ New</a>
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
        <?php $disp_len = 4; $min = 3; ?>
        <select name="display_radiogroup" class="form-control" id="display_radiogroup">
            <?php for($i = 1; $i <= $disp_len; $i++): ?>
               <option value="<?php echo e('col-'.$min*$i); ?>" <?php if(isset($display)): ?><?php if($i == $display): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($i); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-12  form-group " id="sortable-11">
    <!-- <form> --> 
    <?php if(isset($content) && $content !=  ''): ?>
        <?php
            $radioContent = json_decode($content);  
        ?>

        <?php $__currentLoopData = $radioContent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($c->label)): ?>
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="opt_radiogroup" <?php if(isset($c->is_checked)): ?><?php echo e(($c->is_checked==1) ? 'checked' : ''); ?><?php endif; ?>>Option 1</label>
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
            <label  style="color:transparent"><input type="radio" name="optradio" checked>Option 1</label>
            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
            <label  >Score</label>
            <input  class ="radio_score" type="text"   value="" style="margin-right:1vw">
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>
        <div class="radio">
            <label  style="color:transparent"><input type="radio" name="optradio" >Option 2</label>
            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
            <label  >Score</label>
            <input  class ="radio_score" type="text"   value="" style="margin-right:1vw">
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="42">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>
        <div class="radio">
            <label  style="color:transparent"><input type="radio" name="optradio" >Option 2</label>
            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
            <label  >Score</label>
            <input   class ="radio_score"  type="text"   value="" style="margin-right:1vw">
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="43">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/questions/components/simple/radiogroup.blade.php ENDPATH**/ ?>