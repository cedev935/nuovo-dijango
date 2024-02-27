<?php $__env->startSection('title', __('labels.backend.textgroups.title').' | '.app_name()); ?>
<?php $__env->startPush('after-styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/admin/textgroup.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <input type="hidden" id="textgroup_id" value="<?php echo e($current_textgroup->id); ?>" />
            <h3 class="page-title float-left mb-0">Textgroup Edit</h3>
            <div class="float-right">
                <a 
                    href="<?php echo e(route('admin.textgroups.index', ['course_id' => request('course_id'), 'test_id'=>request('test_id')])); ?>" 
                    class="btn btn-success"
                >
                    <i class="fa fa-list-ul"></i> <?php echo app('translator')->get('labels.backend.textgroups.view'); ?>
                </a>
            </div>         
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row form-group">
                        <?php echo Form::label('course_id', trans('labels.backend.tests.fields.course'), ['class' => 'col-md-2 form-control-label']); ?>

                        <div class="col-md-10">
                            <?php echo Form::select('course_id', $courses, request('course_id', old('course_id')), ['class' => 'form-control select2']); ?>

                        </div>
                    </div>    
                    <div class="row form-group">
                        <?php echo Form::label('tests_id', 'Test List *', ['class' => 'col-md-2 form-control-label']); ?>

                        <div class="col-md-10">
                            <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(in_array(intval($test->id), $test_ids)): ?>
                                        <option value="<?php echo e($test->id); ?>" selected><?php echo e(strip_tags($test->title)); ?></option>                             
                                    <?php else: ?>
                                        <option value="<?php echo e($test->id); ?>"><?php echo e(strip_tags($test->title)); ?></option>                             
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                            </select> 
                        </div>
                    </div>
                    <div class="row form-group has-info">
                        <?php echo Form::label('title', 'Title *', ['class' => 'col-md-2 form-control-label']); ?>

                        <div class="col-md-10">
                            <input id="title" type="text" class="form-control required" value="<?php echo e($current_textgroup->title); ?>" />
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
    <div class="card position-relative">
        <div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i></div>
        <div class="card-header">
            <h3 class="page-title mb-0">Textgroup</h3>           
        </div>
        <div class="card-body row">
            <div class="col-12 text-box">
<?php 
$content =  json_decode($current_textgroup->content);
$score =  json_decode($current_textgroup->score);
$logic   =  json_decode($current_textgroup->logic);
$operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
$qtypes = ["Single Input", "Check Box", "RadioGroup", "Image", "Matrix", "Rating", "Dropdown", "File", "Stars", "Range", "€"];
for ($i=0; $i<count($content); $i++) {
?>
<div class="row text m-2 p-2 pb-3" id="text_<?php echo e($i); ?>">
    <div class="col-12 form-group content-box">
        <div class="form-group form-md-line-input">                   
            <label class="control-label pl-2">Text *</label> 
            <textarea class="form-control text_msg" rows="2" placeholder="Please input the Text...">
                <?php echo e($content[$i]); ?>

            </textarea>   
        </div>
        <div class="form-group row">
            <label class="control-label col-md-2">Score *</label>  
            <div class="col-md-10">  
                <input class="form-control text_score" type="number" value="<?php echo e($score[$i]); ?>" />  
            </div>
        </div>      
    </div> 
    <div class="col-12 form-group condition-box">
    <?php 
        for ($j=0; $j<count($logic[$i]); $j++) { 
            $target= -1;
            for ($n=0;$n<count($question_infos);$n++)
            {
                if($question_infos[$n]->id == $logic[$i][$j][1])
                {
                    $target = $n;
                    break;
                }  
            }
            if ($target < 0)
                continue;
        $qa = $question_infos[$target];
        $question_info= json_decode($qa->content);
    ?>
        <div class="row mt-3 condition" id="condition_<?php echo e($i); ?>_<?php echo e($j); ?>">
            <div class="col-sm-2">
                <i style="font-size:24px" class="fa float-left fa-link pt-2 pr-2"></i>
                <select style="width:auto;" class="form-control float-left btn-primary first_operator" name="first_operator" placeholder="Options">
                    <option value="0" <?php if ($logic[$i][$j][0]==0) echo 'selected';?>>And</option>
                    <option value="1" <?php if ($logic[$i][$j][0]==1) echo 'selected';?>>Or</option>
                </select>
            </div>
            <div class="col-sm-8">                                            
                <?php
                    $is_condition_logic = count(json_decode($qa->logic))>0 ? ' - <strong>condition Logic</strong>' : '';
                    $score_htm = '';
                    if ($qa->content!=null) {
                        $to = json_decode($qa->content);
                        if (is_array($to)) {
                            foreach ($to as $cont1) {
                                if (isset($cont1->score) && $cont1->score!=null)
                                {
                                    $score_htm.=json_encode($cont1->score).', ';
                                }
                            }
                        }
                    }
                    if ($score_htm!='') $score_htm = ' <b>Score:'.$score_htm.'</b>';
                ?>
                <div class="qt_name form-control">
                    <span class="type-<?php echo e($qa->questiontype); ?>"><i class="fa fa-folder"></i></span> <?php echo e($qa->id .'. '. strip_tags($qa->question)); ?> - <span>[<?php echo e($qtypes[$qa->questiontype]); ?>]</span><?php echo $score_htm.$is_condition_logic; ?>

                </div>
                <div class="logic_tree" style="display:none">
                    <ul class="treecontent">
                        <?php for($q=0; $q<count($course_list); $q++): ?>
                        <li>                  
                        <?php echo e($course_list[$q]['title']); ?>

                            <ul>
                                <?php for($r=0; $r<count($course_test_list[$q]); $r++): ?>
                                    <li>
                                        <?php echo e($course_test_list[$q][$r]['title']); ?>

                                        <ul>
                                            <?php
                                                $tk=  $course_test_list[$q][$r]['id'];
                                            ?>
                                            <?php if(isset($question_list[$tk])): ?>
                                                <?php $__currentLoopData = $question_list[$tk]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $is_condition_logic = count(json_decode($question_item['logic']))>0 ? ' - <strong>condition Logic</strong>' : '';
                                                        $score_htm = '';
                                                        if ($question_item['content']!=null) {
                                                            $t = json_decode($question_item['content']);
                                                            if (is_array($t)) {
                                                                foreach ($t as $cont) {
                                                                    if (isset($cont->score) && $cont->score!=null)
                                                                    {
                                                                        $score_htm.=json_encode($cont->score).', ';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($score_htm!='') $score_htm = ' <b>Score:'.$score_htm.'</b>';
                                                    ?>
                                                    <?php if($question_item['id'] == $logic[$i][$j][1]): ?>
                                                        <li class="type-<?php echo e($question_item['questiontype']); ?> jstree-clicked"><?php echo e($question_item['id'] .'.'. strip_tags($question_item['question'])); ?> <span>[<?php echo e($qtypes[$question_item['questiontype']]); ?>]</span><?php echo $score_htm.$is_condition_logic; ?></li>
                                                    <?php else: ?>
                                                        <li class="type-<?php echo e($question_item['questiontype']); ?>"><?php echo e($question_item['id'] .'.'. strip_tags($question_item['question'])); ?> <span>[<?php echo e($qtypes[$question_item['questiontype']]); ?>]</span><?php echo $score_htm.$is_condition_logic; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </li>                                     
                        <?php endfor; ?>
                    </ul>                   
                </div>
            </div>
            <input class="qt_type" type="hidden" value="<?php echo e($qa->questiontype); ?>" />
            <div class="col-sm-2">                                    
                <select class="form-control btn-warning operators" name="operators" placeholder="Options">
                    <?php for($k=0; $k<count($operators); $k++) { ?>
                        <?php if($logic[$i][$j][2]==$k): ?>
                            <option value="<?php echo e($k); ?>" selected><?php echo e($operators[$k]); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($k); ?>"><?php echo e($operators[$k]); ?></option>
                        <?php endif; ?>
                    <?php } ?>                                       
                </select>
            </div>
            <div class="col-12 logic-content">
                <?php if($qa->questiontype == 1): ?>
                    <div class="row  main-content" id="cond_<?php echo e($qa->id); ?>"  > 
                        <div class="col-12 form-group logic_check">
                            <?php for($num= 0; $num < count($question_info) - 2; $num++): ?>
                            <?php
                                $check_vals = json_decode($logic[$i][$j][3]);
                            ?>
                                <div class="checkbox">
                                    <?php if( data_get($question_info, [$num, 'score']) == $check_vals): ?>
                                        <label><input type="checkbox" class="checkbox_<?php echo e($num); ?> check_box_q" value="<?php echo e(data_get($question_info, [$num, 'score'])); ?>" checked><?php echo e(data_get($question_info, [$num, 'label'])); ?></label>
                                    <?php else: ?>
                                        <label><input type="checkbox"  class="checkbox_<?php echo e($num); ?> check_box_q" value="<?php echo e(data_get($question_info, [$num, 'score'])); ?>"><?php echo e(data_get($question_info, [$num, 'label'])); ?></label>
                                    <?php endif; ?>
                                </div>
                            <?php endfor; ?>    
                        </div>           
    
                    </div>
                <?php elseif($qa->questiontype == 2 || $qa->questiontype == 5 || $qa->questiontype == 6 || $qa->questiontype == 8): ?>
                    <div class="row main-content" id="cond_<?php echo e($qa->id); ?>"> 
                        <div class="col-12 form-group logic_radio">
                            <?php for($num= 0; $num < count($question_info) - 2; $num++): ?>
                            <?php
                                $check_vals = json_decode($logic[$i][$j][3]);
                            ?>
                                <div class="checkbox">
                                    <?php if( data_get($question_info, [$num, 'score']) == $check_vals): ?>
                                        <label><input type="radio" name="radio_<?php echo e($j); ?>_<?php echo e($q); ?>" class="radio_<?php echo e($num); ?> check_box_q" value="<?php echo e(data_get($question_info, [$num, 'score'])); ?>" checked><?php echo e(data_get($question_info, [$num, 'label'])); ?></label>
                                    <?php else: ?>
                                        <label><input type="radio" name="radio_<?php echo e($j); ?>_<?php echo e($q); ?>" class="radio_<?php echo e($num); ?> check_box_q" value="<?php echo e(data_get($question_info, [$num, 'score'])); ?>"><?php echo e(data_get($question_info, [$num, 'label'])); ?></label>
                                    <?php endif; ?>
                                </div>
                            <?php endfor; ?>    
                        </div> 
                    </div>
                <?php elseif($qa->questiontype == 3): ?>
                    <div class="row main-content logic_img"  id="cond_<?php echo e($qa->id); ?>"  > 
                        <?php
                            $images = $question_info[0]->image;
                            $scores = $question_info[0]->score;
                        ?>
                        <?php for($num= 0; $num < count($images); $num++): ?>
                        <?php
                            $check_vals = json_decode($logic[$i][$j][3]);
                        ?>
                            <div class="col-md-3 col-sm-6 image_box" style="padding-left:20px;width:7vw;height:10vw;" display="inline-flex" >
                                <div  class="checkbox">
                                    <?php if( $check_vals[$num] > 0): ?>
                                        <input type="checkbox" class="imagebox_<?php echo e($num); ?>" checked value="<?php echo e($scores[$num]); ?>">
                                    <?php else: ?>
                                        <input type="checkbox"  class="imagebox_<?php echo e($num); ?>" value="<?php echo e($scores[$num]); ?>">
                                    <?php endif; ?>
                                </div>
                                <img src="<?php echo e(asset("uploads/image/".$images[$num])); ?>"  width="50px" height="50px" style="object-fit:fill">
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php elseif($qa->questiontype == 4): ?>
                    <div class="row main-content" id="cond_<?php echo e($qa->id); ?>"  >
                        <div class="col-12 form-group logic_radio">
                        <?php
                            $input_vals = json_decode($logic[$i][$j][3]);
                            $inputs = explode('type="text" value="', $question_info);
                            $table_html = "";
                            for($y = 0; $y < count($inputs); $y++){
                                if($y == count($inputs) - 1)
                                    $table_html .= $inputs[$y];
                                else{
                                    $table_html .= $inputs[$y].'type="text" value="'.$input_vals[$y];
                                }
                            }
                            echo $table_html;
                        ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row main-content" id="cond_<?php echo e($qa->id); ?>"  > 
                        <div class="col-12 form-group">
                            <div class="form-group form-md-line-input has-info">
                                <textarea class="form-control" rows="1"><?php echo e($logic[$i][$j][3]); ?></textarea>
                                <label>Please enter/select the value </label>    
                            </div>  
                        </div>                                                 
                    </div>
                <?php endif; ?>

            </div>
            <a class="del-condition-btn" href="javascript:del_condition(<?php echo e($i); ?>, <?php echo e($j); ?>);"><i class="fa fa-close"></i></a>
            <a class="clone-condition-btn" href="javascript:clone_condition(<?php echo e($i); ?>, <?php echo e($j); ?>);"><i class="fa fa-clone"></i></a>
        </div>
    <?php } ?>
    </div>        
    <div class="col-12">    
        <a class="btn btn-primary condition_add mt-2" href="javascript:add_condition(<?php echo e($i); ?>);"><i class="fa fa-plus"></i> Add Conditon</a>
    </div>     
    <a class="clone-text-btn" href="javascript:clone_text(<?php echo e($i); ?>);"><i class="fa fa-clone"></i></a>
    <a class="del-text-btn" href="javascript:del_text(<?php echo e($i); ?>);"><i class="fa fa-close"></i></a>
    <span class="text-label"><?php echo e(($i+1)); ?></span>                   
</div>
<?php } ?>
            </div>   
            <div class="col-12">
                <div class="row text m-3">
                    <a class="btn add-text-btn" href="javascript:add_text()">
                        <i class="fa fa-2 fa-plus-square"></i> New Text
                    </a>  
                </div>
            </div>
        </div> 
    </div>
    <div class="float-right">
        <a class="btn btn-danger" href="javascript:save_data();"><i class="fa fa-save"></i> Save TextGroup</a>  
    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/textgroup-create.js')); ?>?t=<?php echo e(time()); ?>"></script>
    <script>
        $(document).on('change', '#course_id', function (e) {
            var course_id = $(this).val();
            window.location.href = "?course_id=" + course_id
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/textgroups/edit.blade.php ENDPATH**/ ?>