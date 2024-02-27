<?php $__env->startPush('after-styles'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/font-awesome5.7.2/css/font-awesome.min.css')); ?>"/>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/>
    <link href="<?php echo e(asset('plugins/touchpdf-master/jquery.touchPDF.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://unpkg.com/survey-core@1.8.63/modern.min.css" type="text/css" rel="stylesheet"/>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>?t=<?php echo e(time()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/responsible-table.scss')); ?>">

    <script type="text/javascript" src="<?php echo e(asset('js/3.5.1/jquery.min.js')); ?>"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/knockout@3.5.1/build/output/knockout-latest.js"></script>
    <script src="https://unpkg.com/survey-knockout@1.8.63/survey.ko.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
    <script type="text/javascript" src="<?php echo e(asset('js/user-question.js')); ?>?t=<?php echo e(time()); ?>"></script>
    <style>
        #report {
            position: relative;
            margin: auto;
        }

        canvas {
            border: 0 dotted red;
        }

        body {  
            padding: 16px;
        }

        .report-card {
            border : 2px dashed #555;
            font-size:24px;
        }

        @media  only screen and (max-width: 800px) {
    
            /* Force table to not be like tables anymore */
            #no-more-tables table, 
            #no-more-tables thead, 
            #no-more-tables tbody, 
            #no-more-tables th, 
            #no-more-tables td, 
            #no-more-tables tr { 
                display: block; 
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            #no-more-tables tr { border: 1px solid #ccc; }

            #no-more-tables td { 
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%; 
                white-space: normal;
                text-align:left;
            }

            #no-more-tables td:before { 
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
                text-align:left;
                font-weight: bold;
            }

            /*
            Label the data
            */
            #no-more-tables td:before { content: attr(data-title); }
        }

        table, th, td {
            border: 1px solid grey!important;
        }
        table{
            border-collapse: collapse;
        }
        td.rwd {
            text-align:right;
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">
                        <span><?php echo e($lesson->course->title); ?></span>
                    </h2>
                </div>
            </div>
        </div>
    </section>
    

    <section id="course-details" class="course-details-section">
        <div class="container-fluid">
        <input type="hidden" value="<?php echo e($lesson->course->id); ?>" id='course_id' name="course_id">
        <div class="row">
            
           
            <?php          
                            
                $percent = $lesson->course->progress();
                
                $exists = \DB::table('courses')->where('id',$lesson->course_id)->count();
                if($exists){
                    $percent = (isset($percentage[$test_id_f]))?$percentage[$test_id_f]:'0';
                    $percent = round($percent,2);
                }
                if(isset($reported->reported)){
                    $reported = $reported->reported;
                }else{
                    $reported = 0;
                }
            ?>
            <input type="hidden" id="percent" value="<?php echo e($percent); ?>">
            <input type="hidden" id="reported" value="<?php echo e($reported); ?>">
            <div class="row w-100  justify-content-md-center mb-5">
                <div class="b_progress_container">
                    <div class="b_progress_bar gradient-bg" style="width:min(<?php echo e($percent); ?>%, 100%);">
                        
                    </div>
                    <div class="b_progress gradient-bg" style="left: max(0px, calc(min(<?php echo e($percent); ?>%, 100%) - 4%));">
                        <?php echo e(min(100, round($percent))); ?>%
                    </div>
                </div>
            </div>
            <!-- End Bilal Code -->
            
        </div>
        <div class="row mt-5">
            
            <div class="col-md-9">
                <?php if(session()->has('success')): ?>
                    <div class="alert alert-dismissable alert-success fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php echo $__env->make('includes.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <input type="hidden" id="test_id" name="lesson_id" value="<?php echo e($lesson->id); ?>" >
                
                <div class="course-details-item border-bottom-0 mb-0">
                    <?php if($lesson->lesson_image != ""): ?>
                        <div class="course-single-pic mb30">
                            <img src="<?php echo e(asset('storage/uploads/'.$lesson->lesson_image)); ?>" alt="">
                        </div>
                    <?php endif; ?>
                    <div class="course-single-text">
                        <div class="course-title mb-1 headline relative-position">
                            <h3><b><?php echo e($lesson->title); ?></b></h3>
                        </div>
                        <div class="course-details-content">
                            <p> <?php echo $lesson->full_text; ?> </p>
                        </div>
                    </div>
                    <hr/>
                    <?php if($test_exists): ?>
                        <?php if(!is_null($test_result)): ?>
                            <div class="alert alert-info">
                                <?php echo app('translator')->get('labels.frontend.course.your_test_score'); ?> : <?php echo e($test_result->test_result); ?>

                            </div>

                            <?php if(config('retest')): ?>
                                <form action="<?php echo e(route('lessons.retest',[$test_result->test->slug])); ?>" method="post" >
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="result_id" value="<?php echo e($test_result->id); ?>">
                                    <button type="submit" class="btn gradient-bg font-weight-bold text-white"
                                            href="">
                                        <?php echo app('translator')->get('labels.frontend.course.give_test_again'); ?>
                                    </button>
                                </form>
                            <?php endif; ?>
                            
                            <?php if(count($lesson->questions) > 0  ): ?>
                                <hr>
                                <?php $__currentLoopData = $lesson->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <h4 class="mb-0">
                                        <?php echo e($loop->iteration); ?>. <?php echo $question->question; ?>

                                        <?php if(!$question->isAttempted($test_result->id)): ?>
                                            <small class="badge badge-danger"> <?php echo app('translator')->get('labels.frontend.course.not_attempted'); ?></small>
                                        <?php endif; ?>
                                    </h4>
                                    <br/>
                                    <ul class="options-list pl-4">
                                        <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="<?php if(($option->answered($test_result->id) != null && $option->answered($test_result->id) == 1) || ($option->correct == true)): ?> correct <?php elseif($option->answered($test_result->id) != null && $option->answered($test_result->id) == 2): ?> incorrect  <?php endif; ?>"> <?php echo e($option->option_text); ?>

                                                <?php if($option->correct == 1 && $option->explanation != null): ?>
                                                    <p class="text-dark">
                                                        <b><?php echo app('translator')->get('labels.frontend.course.explanation'); ?></b><br>
                                                        <?php echo e($option->explanation); ?>

                                                    </p>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <br/>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <h3><?php echo app('translator')->get('labels.general.no_data_available'); ?></h3>
                            <?php endif; ?>
                        <?php else: ?>
                            
                            <div class="test-form">
                            <input type="hidden" name="current_page" value="1">
                                <?php if(count($lesson->questions) > 0  ): ?>
                                    <form action="<?php echo e(route('lessons.test', [$lesson->slug])); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <div id="question_form" >
                                            <?php echo $__env->make('frontend.components.questions.questions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                            
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
                
                
                
                <div id="report"></div>
                

            </div>
            
            

            
            <div class="col-md-3">
                <div id="sidebar" class="sidebar">
                    <div class="course-details-category ul-li">
                        <div class="prev_next">
                            <?php if($previous_lesson): ?>
                                <p><a class="btn-block new-btn gradient-bg font-weight-bold text-white"
                                        href="<?php echo e(route('lessons.show', [$previous_lesson->course_id, $previous_lesson->model->slug])); ?>"><i
                                                class="fas fa-angle-double-left"></i>
                                        <?php echo app('translator')->get('labels.frontend.course.prev'); ?></a></p>
                            <?php endif; ?>

                            <?php if($next_lesson): ?> 
                            <p id="nextButton">
                                <?php if((int)config('lesson_timer') == 1 && $lesson->isCompleted() ): ?>
                                    <a class="btn-block new-btn gradient-bg font-weight-bold text-white"
                                        href="<?php echo e(route('lessons.show', [$next_lesson->course_id, $next_lesson->model->slug])); ?>"><?php echo app('translator')->get('labels.frontend.course.next'); ?>
                                        <i class='fas fa-angle-double-right'></i> </a>
                                <?php else: ?>
                                    <a class="btn-block new-btn gradient-bg font-weight-bold text-white"
                                        href="<?php echo e(route('lessons.show', [$next_lesson->course_id, $next_lesson->model->slug])); ?>"><?php echo app('translator')->get('labels.frontend.course.next'); ?>
                                        <i class='fas fa-angle-double-right'></i> </a>
                                <?php endif; ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <?php if($lesson->course->progress() == 100): ?>
                            <?php if(!$lesson->course->isUserCertified()): ?>
                                <form method="post" action="<?php echo e(route('admin.certificates.generate')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" value="<?php echo e($lesson->course->id); ?>" id='course_id' name="course_id">
                                    <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold gradient-bg"
                                            id="finish"><?php echo app('translator')->get('labels.frontend.course.finish_course'); ?></button> 
                                </form> 
                            <?php else: ?> 
                                <div class="alert alert-success"> 
                                    <?php echo app('translator')->get('labels.frontend.course.certified'); ?>
                                </div> 
                            <?php endif; ?> 
                        <?php endif; ?> 

                        <span class="float-none"><?php echo app('translator')->get('labels.frontend.course.course_timeline'); ?></span> 
                        <ul class="course-timeline-list">
                            <?php $__currentLoopData = $lesson->course->courseTimeline()->orderBy('sequence')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->model && $item->model->published == 1): ?>
                                    
                                    <li class="<?php if($lesson->id == $item->model->id): ?> active <?php endif; ?> ">
                                        <a <?php if(in_array($item->model->id,$completed_lessons)): ?>href="<?php echo e(route('lessons.show',['course_id' => $lesson->course->id,'slug'=>$item->model->slug])); ?>"<?php endif; ?>>
                                            <?php echo e($item->model->title); ?>

                                            <?php if($item->model_type == 'App\Models\Test'): ?>
                                                <p class="mb-0 text-primary">
                                                    - <?php echo app('translator')->get('labels.frontend.course.test'); ?></p>
                                            <?php endif; ?>
                                            <?php if(in_array($item->model->id,$completed_lessons)): ?> <i
                                                    class="fas float-right fa-check-square"></i> <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

                


                <div class="hint-box" style="display: none;">
                    <h3>Help</h3>
                    <hr class="mb-1" />
                    <div class="hint-content"></div>
                </div>
            </div>
            
            
        </div>
        <?php echo $__env->make('frontend.components.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('after-scripts'); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
        getHelp();
        function test(ele){
            alert("$(ele).val()");
        }
        if(document.getElementById('range') != null){
        $(function() {
            const range = document.getElementById('range'),
            tooltip = document.getElementById('tooltip'),
            setValue = ()=>{
                const
                    newValue = Number( (range.value - range.min) * 100 / (range.max - range.min) ),
                    newPosition = 16 - (newValue * 0.32);
                tooltip.innerHTML = `<span>${(parseInt(range.value))}</span>`;
                tooltip.style.left = `calc(${newValue}% + (${newPosition}px))`;
                document.documentElement.style.setProperty("--range-progress", `calc(${newValue}% + (${newPosition}px))`);
            };
            document.addEventListener("DOMContentLoaded", setValue);
            range.addEventListener('input', setValue);
            setValue();
        });
       }
        $('.rangeslider').on('input',function(){
                $(this).val();
                $(this).parent('.range').find('output').html($(this).val());
            });
        $(".btn-minus").click(function(){
            var value = $(this).closest('.radiogroup').find(".rangevalue").val();
            value--;
           $(this).closest('.radiogroup').find(".rangevalue").val(value);
        });
        $(".btn-plus").click(function(){
            var value = $(this).closest('.radiogroup').find(".rangevalue").val();
            value++;
            $(this).closest('.radiogroup').find(".rangevalue").val(value);
        });
        $(".rating-stars .star").click(function(event){
            if($('#percent').val() == 1000 && $('#reported').val() == 10){
                event.preventDefault();
                alert('You can not edit your answer!');
            } else {
                var value = $(this).data('value');

                $(this).closest('.rating-stars').find('.star i').css('color','var(--qcolor2)');
                $(this).closest('.rating-stars').find('.starinput').val(value);

                for(i=1;i<=value;i++){
                    $(this).closest('.rating-stars').find('.star-'+i+' i').css('color','var(--qcolor1)');
                }
            }
        });
        $(".rate").click(function(){
            if($('#percent').val() == 1000 && $('#reported').val() == 10){
                event.preventDefault();
                alert('You can not edit your answer!');
            }else{
                var value = $(this).data('value');
                
                $(this).closest('.rating-box').find('.rate').css({
                    'background': 'transparent',
                    'color': 'var(--active-color, #333333)'
                });

                $(this).closest('.rating-box').find('.ratinginput').data("selected","true");

                var rating_input = $(this).closest('.rating-box').find('.ratinginput')[0];
                rating_input.dataset.selected = true;

                $(this).closest('.rating-box').find('.ratinginput').val(value);
                $(this).closest('.rating-box').find('.active').removeClass('active');

                $(this).addClass('active').css({
                    'background': 'var(--qcolor2, #333333)',
                    'color': '#fff'
                });
            }
        });
        $(".btn-add-answer").click(function(){
            var html = '<div class="mb-2"><input type="text" class="form-control" placeholder="Write your answer"><span class="message"></span></div>';
            $(this).closest('.single-input').find('.more_answers').append(html);
        });
        $(".square-check").click(function(event){
            if($('#percent').val() == 1000 && $('#reported').val() == 10){
                event.preventDefault();
                alert('You can not edit your answer!');
            }else {
                var opendivid = $(this).find('input[name="checkbox-radio"]').data('opendiv');
                if(opendivid != undefined){
                    // $("#question"+opendivid).removeClass('d-none');
                    $("#question"+opendivid).toggleClass('d-none');
                    // $("#question"+opendivid).addClass('bilal-hide-class');
                }
                var square_checkes = $(this).closest('.check_content').find('.square-check');
                var v = $(this).find('input[name="checkbox-radio"]').prop('checked');
                $(this).find('input[name="checkbox-radio"]').prop('checked',!v);
                $(this).toggleClass('toggle_btn_active');
                for(var i = 0; i < square_checkes.length; i++){
                        if($(square_checkes[i]).find(':radio').data('key') != $(this).find(':radio').data('key')){
                            if($(square_checkes[i]).hasClass('toggle_btn_active')){
                                $(square_checkes[i]).removeClass('toggle_btn_active');
                                $(square_checkes[i]).find('input[type="radio"]').prop('checked', false);
                            }
                            $(square_checkes[i]).find('input[type="radio"]').prop('checked', false);
                        }
                }
            }
        });
        var image_part_data = [];
       
        var question_img_data = [];
    

        var questions = $(".question-card");
        var page_cnt = 0; // count the pages number, 0 is first page
        var current_page = $('input[name="current_page"]').val(); // when clikc the next-pg button, increase 1, prev-button, decrease 1;
        var max_page = 0;
        $("#pre-pg").hide();
        //start counting pages number
        for(var i = 0; i < questions.length; i++){
            if($(questions[i]).data('page') > 0){
                page_cnt++;
            }
            if(i == 0){
                max_page = $(questions[i]).data('page');
            }else if($(questions[i]).data('page') > max_page){
                max_page = $(questions[i]).data('page');
            }
        }
        //end counting
        if(max_page == 1){ //max page is 1, show report button, hide navigation buttons
            $('#navigation-btns').hide();
            $("#report_div").show();
        }else {
            for(var s = 0; s < questions.length; s++){
                if($(questions[s]).data('page') == current_page){
                    $(questions[s]).show();
                }else{
                    $(questions[s]).hide();
                }
            }
            if(page_cnt > 0){
                $("#navigation-btns").show();
                $("#report_div").hide();
            }else{
                $("#navigation-btns").hide();
            }
            $("#next-pg").click(function(e){
                current_page++;
                $('input[name="current_page"]').val(current_page);
                $("#pre-pg").show();
                if(current_page == max_page){
                    $(this).hide();
                    if($('#update_report_div').is(":hidden")){ //when you create report and show save report button, not show report button again..
                        $("#report_div").show();
                    }else{
                        $("#report_div").hide();
                    }
                }
                qt_show_with_page(current_page);
            });
            $("#pre-pg").click(function(e){
                current_page--;
                $('input[name="current_page"]').val(current_page);
                $("#next-pg").show();
                $("#report_div").hide();
                if(current_page == 1){
                    $(this).hide();
                }
                qt_show_with_page(current_page);
            });
        }

        function qt_show_with_page(current_page){
           $('input[name="current_page"]').val(current_page);
           for(var k = 0; k < questions.length; k++){
                if($(questions[k]).data('page') == $('input[name="current_page"]').val()){
                    $(questions[k]).show();
                }else {
                    $(questions[k]).hide();
                }
           }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app'.config('theme_layout'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/courses/lesson.blade.php ENDPATH**/ ?>