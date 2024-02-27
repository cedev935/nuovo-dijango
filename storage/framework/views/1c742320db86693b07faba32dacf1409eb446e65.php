
<?php
    $image_count = 2;
    if(isset($question->content) && $question->content != null){
        $content = json_decode($question->content);
        if(is_array($content)){
            $col = isset($content[(sizeof($content))-1]->col)?$content[(sizeof($content))-1]->col:'';
        }
        else{
            $col = '';
        }
        
    }
?>
<div id="image_part" class="row question-box" <?php if(isset($display)): ?> style="display:<?php echo e($display); ?>;" <?php endif; ?>>
    <?php
        if(isset($question)) 
        {
            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);
            echo Form::color('color1', $question->color1 ? $question->color1 : data_get($current_tests, '0.color1'), ['class' => 'form-control ', 'name'=>'color1']);
            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);
            echo Form::color('color2', $question->color2 ? $question->color2 : data_get($current_tests, '0.color2'), ['class' => 'form-control ', 'name'=>'color2']);
        }
        else {
            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);
            echo Form::color('color1', '', ['class' => 'form-control ', 'name'=>'color1']);
            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);
            echo Form::color('color2', '', ['class' => 'form-control ', 'name'=>'color2']);
        }
    ?>
    <div class="col-12">
        <label for="">Select Display</label>
        <?php if(isset($content)): ?>
           <?php
               $con = $content;
               foreach($con as $key => $c){
                   if(isset($c->display)){
                       $display = $c->display;
                   }
               }
           ?>
        <?php endif; ?>

        <?php $disp_len = 4; $max = 12; ?>
        <select name="display_image" class="form-control" id="display_image">
            <?php for($i = 1; $i <= $disp_len; $i++): ?>
               <option value="<?php echo e('col-'.$max/$i); ?>" <?php if(isset($display)): ?><?php if($i == $display): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($i); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-md-12 form-body">
        <div class="form-group ">
            <!-- <label class="control-label col-md-3">Image Upload</label> -->
            <div class="col-md-12 p-0 m-0">
                <form method="POST" enctype="multipart/form-data" class="image-upload-form" action="javascript:void(0)" id="sortable-13">
                    <?php echo csrf_field(); ?>
                    <div class="form-group " id="sortable-11">
                        <div class="input-group hdtuto control-group lst increment image_part_file" style="margin-right:30%">
                            
                            
                            <div class="input-group-btn"> 
                                <button class="btn btn-success add-btn" type="button">
                                    +
                                </button>
                            </div>
                            
                            
                        </div>
                            <?php if(isset($content) && data_get($content, '0.image')): ?>
                                <?php $__currentLoopData = $content[0]->image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="image_part_file" >
                                        <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                            <div style="display: flex; flex-direction: column;">
                                                <label class="mb-0">Image</label>

                                                <input  class="imge_names" type="hidden" value="<?php echo e($c); ?>">

                                                <div class="input-group-btn d-flex">
                                                    <input type="file" name="file[]" class="b-images images myfrm form-control">
                                                    <button class="btn btn-danger del-btn" type="button">
                                                        <i class="fa fa-trash" style="color:white"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div style="display: flex; gap: 1rem; padding: 0 2rem; flex: 1;">
                                                <div style="display: flex; flex-direction: column; flex: 1;">
                                                    <label>Description</label>

                                                    <input
                                                        type="text"
                                                        class="image_description"
                                                        value="<?php echo e(data_get($content, [0, 'description', $key])); ?>"
                                                    />
                                                </div>

                                                <div style="display: flex; flex-direction: column;">
                                                    <label>Score</label>

                                                    <input
                                                        type="text"
                                                        class="image_score"
                                                        style="max-width: 4rem;"
                                                        value="<?php echo e(data_get($content, [0, 'score', $key])); ?>"
                                                    />
                                                </div>
                                            </div>

                                            <img
                                                width="50px"
                                                height="50px"
                                                alt="preview"
                                                style="object-fit:cover"
                                                src="<?php echo e(asset("uploads/image/".$c)); ?>"
                                            />
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="image_part_file">
                                    <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                        <input type="file" name="file[]" class="b-images images myfrm form-control q">

                                        <div class="input-group-btn">
                                            <button class="btn btn-danger del-btn" type="button">
                                                <i class="fa fa-trash" style="color:white"></i>
                                            </button>
                                        </div>
                                        
                                        <label style="margin-left:5vw;margin-right:1vw;">Descrioption</label>
                                        <input class="image_description" type="text" value="" style="margin-right:1vw">
                                        
                                        <label style="margin-left:5vw;margin-right:1vw;">Score</label>
                                        <input class="image_score" type="text" value="" style="margin-right:1vw">
                                    </div>
                                </div>
                            <?php endif; ?>
                    </div>
                    
                    <div class="clone-sample" style="display: none;">
                        <div class="image_part_file">
                            <div class="hdtuto control-group lst input-group" style="margin-top:10px;padding-right:5.7%;">
                                <div style="display: flex; flex-direction: column;">
                                    <label class="mb-0">Image</label>

                                    <input  class="imge_names" type="hidden">

                                    <div class="input-group-btn d-flex">
                                        <input type="file" name="file[]" class="b-images images myfrm form-control">
                                        <button class="btn btn-danger del-btn" type="button">
                                            <i class="fa fa-trash" style="color:white"></i>
                                        </button>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 1rem; padding: 0 2rem; flex: 1;">
                                    <div style="display: flex; flex-direction: column; flex: 1;">
                                        <label>Description</label>

                                        <input
                                            type="text"
                                            class="image_description"
                                        />
                                    </div>

                                    <div style="display: flex; flex-direction: column;">
                                        <label>Score</label>

                                        <input
                                            type="text"
                                            class="image_score"
                                            style="max-width: 4rem;"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                
                </form>
            </div>
        </div>            
    </div>
</div>   
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/questions/components/simple/image.blade.php ENDPATH**/ ?>