
<div id="file_upload_input" class="question-box" <?php if(isset($display)): ?> style="display:<?php echo e($display); ?>;" <?php endif; ?>>
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
        <input type="text" class="form-control" placeholder="File Input" readonly>
    </div>
    <div class="form-group">
        <label for="Number of Files"> Nuermious of Files </label>
        <input type="number" class="form-control" min="1" id="num_files" name="num_files" placeholder="Please type number of files">
    </div>
    <div class="form-group">
        <label for="Number of Files"> Type of Files </label>
        <?php
            $file_acceptable_exts = ['doc', 'txt', 'xls', 'mbd', 'ppt', 'pdf', 'docx', 'ql', 'zip', 'rar',
            'jpg', 'png', 'gif'];
        ?>
            <select class="form-control select2 required" name="file_acceptable_exts" id="file_acceptable_exts" placeholder="Options" multiple>
            <?php $__currentLoopData = $file_acceptable_exts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ext): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($ext); ?>"><?php echo e($ext); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
        </select>
    </div>
    <div class="form-group">
        <label for="file_max_size"> Dimention of Files (MB) </label>
        <input type="number" class="form-control" min="0.1" id="file_max_size" name="file_max_size" placeholder="Please type maximum size of files" value="2">
    </div>          
</div>                          

    <?php if(isset($question)){?>
<script>
    $("#num_files").val(<?php $cont=$question->content;$obj = json_decode($cont,true);echo isset($obj[0]["number"])?$obj[0]["number"]:""; ?>);
    $("#file_max_size").val(<?php $cont=$question->content;$obj = json_decode($cont,true);echo isset($obj[0]["file_max_size"])?$obj[0]["file_max_size"]:""; ?>);
    var values=<?php
                 $cont=$question->content;
                 $obj = json_decode($cont,true);
                 echo isset(($obj[0]["file_acceptable_exts"]))?json_encode($obj[0]["file_acceptable_exts"]):"[]";
                ?>;
            for(var i=0;i<values.length;i++){
                $("#file_acceptable_exts option[value='" + values[i] + "']").prop("selected", true);
            };
</script>
<?php } ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/questions/components/simple/file.blade.php ENDPATH**/ ?>