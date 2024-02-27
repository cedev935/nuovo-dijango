
<div id="rating_part" class="row question-box" <?php if(isset($display)): ?> style="display:<?php echo e($display); ?>;" <?php endif; ?>>
    <div class="col-12">
        <!--  <a id="rating_add" class="btn btn-success" style="color:white; margin-top:10px;">+ New</a> -->
       <?php if(isset($content)): ?>
           <?php
                $con = json_decode($content);
                $color = $default_color;

                $color2 = $question->color2 ? $question->color2 : $current_tests[0]->color2;

                if(isset($content) && (is_array($content) || $content instanceof Countable)){

                    foreach($con as $key => $c){
                        if(isset($c->color)){
                            $color = $c->color;
                        }
                    }
                }
           ?>
       <?php endif; ?>
        <div class="mb-3">
            <label for="color1">Color 1</label>
            <input type="color" name="color1" id="color1" class="form-control" <?php if(isset($color)): ?>value="<?php echo e($color); ?>"<?php endif; ?>>
        </div>

        <div class="mb-3">
            <label for="color2">Color 2</label>
            <input type="color" name="color2" id="color2" class="form-control" <?php if(isset($color2)): ?>value="<?php echo e($color2); ?>"<?php endif; ?>>
        </div>
    </div>
    <div class="col-12">
        <label for="">Select Display</label>
        <?php if(isset($content)): ?>
           <?php
               $con = json_decode($content);
               if(isset($content) && (is_array($content) || $content instanceof Countable)){

               foreach($con as $key => $c){
                   if(isset($c->display)){
                       $display = $c->display;
                   }
               }
            }
           ?>
       <?php endif; ?>
        <?php $disp_len = 5; $min = 3; ?>
        <select name="display_rating" class="form-control" id="display_rating">
            <?php for($i = 1; $i <= $disp_len; $i++): ?>
                <option value="<?php echo e('col-'.$min*$i); ?>" <?php if(isset($display)): ?><?php if($i == $display): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($i); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-12 form-group" id="sortable_rating">
    
        <?php if(isset($content)): ?>
            <?php
                $content = json_decode($content);
            ?>
            <?php if(isset($content) && (is_array($content) || $content instanceof Countable)): ?>

            <?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($c->label)): ?>
                <div class="radio">
                    <label  style="color:transparent"><input type="radio" name="opt_rating" <?php if(isset($c->is_checked)): ?><?php echo e(($c->is_checked==1) ? 'checked' : ''); ?><?php endif; ?>>Option 1</label>
                    <input class="radio_label" type="text" value="<?php echo e($c->label); ?>" style="margin-left:-2vw;;margin-right:5vw;z-index:20;" required>
                    <label  >Score</label>
                    <input  class ="radio_score" type="text" value="<?php echo e($c->score); ?>" style="margin-right:1vw" required>
                    <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                        <i class="fa fa-trash" style="color:white"></i>
                    </a>
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php else: ?>
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="optradio" checked>Option</label>
                <input class="radio_label" type="text" value="1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;" required>
                <label  >Score</label>
                <input  class ="radio_score" type="text"   value="0" style="margin-right:1vw" required>
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="optradio" >Option</label>
                <input class="radio_label" type="text" value="2" style="margin-left:-2vw;;margin-right:5vw;z-index:20;" required>
                <label  >Score</label>
                <input  class ="radio_score" type="text"   value="0" style="margin-right:1vw" required>
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="42">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
    
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="optradio" >Option</label>
                <input class="radio_label" type="text" value="3" style="margin-left:-2vw;margin-right:5vw;z-index:20;" required>
                <label  >Score</label>
                <input  class ="radio_score" type="text"   value="0" style="margin-right:1vw" required>
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="42">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
    
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="optradio" >Option</label>
                <input class="radio_label" type="text" value="4" style="margin-left:-2vw;;margin-right:5vw;z-index:20;" required>
                <label  >Score</label>
                <input  class ="radio_score" type="text"   value="0" style="margin-right:1vw" required>
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="42">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="optradio" >Option</label>
                <input class="radio_label" type="text" value="5" style="margin-left:-2vw;;margin-right:5vw;z-index:20;" required>
                <label  >Score</label>
                <input  class ="radio_score" type="text"   value="0" style="margin-right:1vw" required>
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="42">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
        <?php endif; ?>

        <p class="help-block"></p>
        <?php if($errors->has('question')): ?>
            <p class="help-block">
                <?php echo e($errors->first('question')); ?>

            </p>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/questions/components/simple/rating.blade.php ENDPATH**/ ?>