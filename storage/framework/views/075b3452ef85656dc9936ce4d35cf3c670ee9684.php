<?php
    $q_number=1;
    $ids = [];
    $identy = [];
    
    if($lesson->color1==NULL)
        $lesson->color1="#ffd1d1";
    if($lesson->color2==NULL)
        $lesson->color2="#badcee";
    if($lesson->text1==NULL)
        $fontstyle1="font-size:16px;font-family:Arial;color:black";
    if($lesson->text2==NULL)
        $fontstyle2="font-size:16px;font-family:Arial;color:black";
    
    // TEXT 1
    preg_match('/font-size:(\d+px)/', $lesson->text1, $matches);
    $LessonFirstFontSize = $matches[1] ?? null;

    preg_match('/#(?:(?:[\da-f]{3}){1,2}|(?:[\da-f]{4}){1,2})/', $lesson->text1, $matches2);
    $LessonFirstColor = $matches2[0] ?? null;

    preg_match('/font-family:([^;]*)/', $lesson->text1, $matches3);
    $LessonFontFamily = explode('"', data_get($matches3, 1))[0] ?? null;

    // TEXT 2
    preg_match('/font-size:(\d+px)/', $lesson->text2, $matches);
    $LessonSecondFontSize = $matches[1] ?? null;

    preg_match('/#(?:(?:[\da-f]{3}){1,2}|(?:[\da-f]{4}){1,2})/', $lesson->text2, $matches2);
    $LessonSecondColor = $matches2[0] ?? null;

    preg_match('/font-family:([^;]*)/', $lesson->text2, $matches3);
    $LessonSecondFontFamily = explode('"', data_get($matches3, 1))[0] ?? null;
?>

<style>
  /* Center the loading spinner */
  #loader {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Add a semi-transparent background to overlay the page */
    z-index: 9999;
  }

  /* Style the spinning icon */
  #loader i {
    font-size: 50px;
    color: white;
  }

  /* Style the message text */
  #loader p {
    color: white;
    text-align: center;
    font-size: 18px;
    margin-top: 10px;
  }
  .curserPointQue{
    cursor: pointer;
  }

  * {
    --bg1: <?php echo e($lesson->color1 ?? "black"); ?>;
    --bg2: <?php echo e($lesson->color2 ?? "black"); ?>;

    --color1: <?php echo e($LessonFirstColor); ?>;
    --color2: <?php echo e($LessonSecondColor); ?>;

    --family1: <?php echo e($LessonFontFamily); ?>;
    --family2: <?php echo e($LessonSecondFontFamily); ?>;

    --size1: <?php echo e($LessonFirstFontSize); ?>;
    --size2: <?php echo e($LessonSecondFontSize); ?>;
  }
</style>

<div class="question-ans">

<?php $__currentLoopData = $lesson->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php
        if($question->logic != "[]"){
            $logic_data = $question->logic;
            $decoded_json_data = json_decode($logic_data);
            foreach($decoded_json_data as $key=>$data){
                $ids[$question->id]=$data[1];
                $identy[$question->id] = $data[3];
            }
        }
    ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $lesson->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $content = json_decode($question->content);
        if($question->questionimage==""){
            $question->questionimage=null;
        }

        $temp = explode('style="',$question->question);
        $text1="";

        foreach($temp as $index)
            if(strrpos($index,'"')>0)
                $text1=$text1.substr($index,0,strrpos($index,'"')).';';
        
        if(strpos($question->question,"strong") == true)
            $text1=$text1."font-weight:bold;";
        if(strpos($question->question,"em") == true)
            $text1=$text1."font-style:italic;";
        $temp = explode('style="',$question->text2);
        $text2="color:black;";
        foreach($temp as $index)
            if(strrpos($index,'"')>0)
                $text2=$text2.substr($index,0,strrpos($index,'"')).';';
        if(strpos($question->question,"strong") == true)
            $text2=$text2."font-weight:bold;";
        if(strpos($question->question,"em") == true)
            $text2=$text2."font-style:italic;";

        $temp = explode('style="',$question->question);
        $fontstyle1="color:black;";
        foreach($temp as $index)
            if(strrpos($index,'"')>0)
                $fontstyle1=$fontstyle1.substr($index,0,strrpos($index,'"')).';';
        if(strpos($question->question,"strong") == true)
            $fontstyle1=$fontstyle1."font-weight:bold;";
        if(strpos($question->question,"em") == true)
            $fontstyle1=$fontstyle1."font-style:italic;";
        
        $temp = explode('style="',$question->help_info);
        $fontstyle2="color:black;";
        foreach($temp as $index)
            if(strrpos($index,'"')>0)
                $fontstyle2=$fontstyle2.substr($index,0,strrpos($index,'"')).';';
        if(strpos($question->help_info,"strong") == true)
            $fontstyle2=$fontstyle2."font-weight:bold;";
        if(strpos($question->help_info,"em") == true)
            $fontstyle2=$fontstyle2."font-style:italic;";

        
    ?>
    <?php
        preg_match('/font-size:(\d+px)/', $text2, $matches);
        $firstFontSize = $matches[1] ?? null;
        preg_match('/font-style:([^;]*)/', $text2, $matches1);
        $firstStyle = $matches1[1] ?? null;
        preg_match('/font-family:([^;]*)/', $text2, $matches2);
        $firstFamily = $matches2[1] ?? null;

        preg_match('/font-size:(\d+px)/', $text1, $matches);
        $firstFontSize1 = $matches[1] ?? null;
        preg_match('/font-style:([^;]*)/', $text1, $matches11);
        $firstStyle1 = $matches11[1] ?? null;
        preg_match('/font-family:([^;]*)/', $text1, $matches12);
        $firstFamily1 = $matches12[1] ?? null;

        preg_match('/color:([^;]*)/', $text1, $matches2);
        $color1 = $matches2[1] ?? null;
        $color1 = preg_match_all("/#([a-fA-F0-9]{3}){1,2}\b/", "$1", $color1);
    ?>

    <script>
        $("body").append(`<style>#q_<?php echo $question->id?> .col-8.p-0{<?php echo $fontstyle1?>}</style>`)
    </script>
    <!-- style="background-color:<?php echo e($lesson->color1); ?>;font-size:<?php echo e($firstFontSize); ?>;font-style:<?php echo e($firstStyle); ?>;font-family:<?php echo e($firstFamily); ?>" -->
    <input  type='hidden' id='firstFontSize' value='<?php echo e($firstFontSize); ?>' />
    <input  type='hidden' id='firstStyle' value='<?php echo e($firstStyle); ?>' />
    <input  type='hidden' id='firstFamily' value='<?php echo e($firstFamily); ?>' />

    <div 
        class="question-box"
        <?php if($question->access_hint_info): ?>
            data-hint="<?php echo e($question->hint_info); ?>"
        <?php endif; ?>
        style="
            --qcolor1: <?php echo e($question->color1); ?>;
            --qcolor2: <?php echo e($question->color2); ?>;
        "
    >
        <?php if(in_array($question->id,$ids)): ?>
            <div id="q_<?php echo e($question->id); ?>" class="question-card card custom-card mb-3" data-page="<?php echo e($question->page_number); ?>" style="font-size:<?php echo e($firstFontSize1); ?>;font-style:<?php echo e($firstStyle1); ?>;font-family:<?php echo e($firstFamily1); ?>;background-color:<?php echo e(($question->question_bg_color != '')?$question->question_bg_color:'#fff'); ?>;box-shadow: 1px 1px 6px <?php echo e(($question->question_bg_color != '' && $question->question_bg_color != '#fff')?'2px':'-3px'); ?>  <?php echo e(($question->question_bg_color != '' && $question->question_bg_color != '#fff')?$question->question_bg_color:'#fff'); ?>;">
                <form id="checkForm">
                <div class="row">
                        <div class="p-0">
                            <span 
                                class="q_number gradient-bg my-auto p-2" 
                                style="
                                    color:<?php if($lesson->color2 != ""){ echo $lesson->color2;  }else{ echo "black";}  ?>;
                                    background:<?php echo e($lesson->color1); ?>;
                                "
                            ><?php echo e($q_number++); ?></span>
                        </div>
                        <div class="p-0 curserPointQue" style="flex: 1;">
                            <?php if($question->titlelocation == 'col-12 order-1'): ?>
                            <?php echo html_entity_decode($question->question); ?>

                        
                            <?php endif; ?>
                        </div>
                        <?php if(!$question->required): ?>
                            <?php
                                $col = 4;
                            ?>
                        <?php else: ?>
                            <?php
                                $col = 2;
                            ?>
                        <?php endif; ?>
                        <?php 
                                if(isset($question->answer_aligment)){
                                    if(($question->answer_aligment == 'offset-md-0')){
                                        $aligment = 'col-12 '.$question->answer_aligment;
                                    }else{
                                        $aligment = $question->answer_aligment;
                                    }
                                }else{
                                    $aligment = 'col-12';
                                }  
                                if(isset($question->image_aligment)){
                                    if(($question->image_aligment == 'offset-md-0')){
                                        $imagealigment = 'col-12 '.$question->image_aligment;
                                    }else{
                                        $imagealigment = $question->image_aligment;
                                    }
                                }else{
                                    $imagealigment = 'col-12';
                                }
                                
                            ?>
                        <div class="col-2 p-0 text-right ">
                            <?php if($question->help_info != "" && $question->access_help_info == 1): ?>
                                <span 
                                    data-toggle="modal" 
                                    data-target="#helpModel" 
                                    onclick='getHelpForModel(<?php echo e($question->id); ?>, "<?php echo e($question->color2); ?>")' 
                                    class="d-inline-block mr-2"
                                >
                                    <?php echo e($question->access_help_info); ?>

                                    <i style="color:<?php if($question->color2 != ""){ echo $question->color2;  }else{ echo "black";}  ?>;font-size:<?php echo e($firstFontSize1); ?>;" class="fas fa-question-circle"></i></span>
                            <?php endif; ?>
                            <?php echo $__env->make('frontend.components.questions.required', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <hr>
                <div class="card-body">
                    <?php if($question->titlelocation == 'col-12' && $question->answerposition == 'col-12' && $question->imageposition == 'col-12'): ?>

                        <!-- question,answer,image in same row but first question,second image and third is answer -->
                        <div class="row">
                            <div class="<?php echo e($question->titlelocation); ?>">
                                <h2 class="curserPointQue" >
                                    <span class=""><?php echo $question->question; ?></span>
                                </h2>
                                <hr />
                            </div>
                            <?php if(filled($question->questionimage)): ?>
                            <div class="<?php echo e($question->imageposition); ?>">
                                <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                            </div>
                            <?php endif; ?>
                            <div class="<?php echo e($aligment); ?>">
                                <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    
                    <?php elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-8 order-2' && $question->imageposition == 'col-4 order-1'): ?>
                        <!-- question,answer,image in same row but first image,second question and third is answer -->      
                        <div class="row">
                            <?php if(filled($question->questionimage)): ?>
                            <div class="col-4">
                                <div class="<?php echo e($imagealigment); ?>">
                                    <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $question->question; ?>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="<?php echo e($aligment); ?>">
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>
                    <?php elseif($question->titlelocation == 'col-6 order-1' && $question->answerposition == 'col-8 order-2' && $question->imageposition == 'col-12 order-2'): ?>
                        <!-- question,answer,image in same row but first question,second image and third is answer -->
                        <div class="row">
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $question->question; ?>

                                </div>
                            </div>
                            <?php if(filled($question->questionimage)): ?>
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $__env->make('frontend. components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>
                    <?php elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-4 order-1'): ?>
                        <!-- question,answer,image in same row but first question,second answer and third is image -->
                        <div class="row">
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $question->question; ?>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <?php if(filled($question->questionimage)): ?>
                                <div class="col-4">
                                    <div class="col-12">
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif($question->titlelocation == 'col-6 order-1' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-4 order-2'): ?>
                        <!-- question,answer,image in same row but first image,second answer and third is question -->
                        <div class="row">
                            <?php if(filled($question->questionimage)): ?>
                                <div class="col-4">
                                    <div class="col-12">
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $question->question; ?>

                                </div>
                            </div>
                        </div>
                    <?php elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-4 order-1'): ?>
                        <!-- question,answer,image in same row but first answer,second question and third is image -->
                        <div class="row">
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $question->question; ?>

                                </div>
                            </div>
                            <?php if(filled($question->questionimage)): ?>
                                <div class="col-4">
                                    <div class="col-12">
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-12 order-2'): ?>
                        <!-- question,answer,image in same row but first answer,second image and third is question -->
                        <div class="row">
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <?php if(filled($question->questionimage)): ?>
                                <div class="col-4">
                                    <div class="col-12">
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-4">
                                <div class="col-12">
                                    <?php echo $question->question; ?>

                                </div>
                            </div>
                        </div>
                    <?php elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-12 order-3' && $question->imageposition == 'col-4 order-1'): ?>
                        <!-- Image(Right) and question(left) and answer bottom of both -->
                            <div class="row">
                                <div class="col-6">
                                    <?php echo $question->question; ?>

                                </div>
                                <?php if(filled($question->questionimage)): ?>
                                    <div class="col-6">
                                        <div class="<?php echo e($imagealigment); ?>">
                                            <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                        </div>
                                    </div>
                                <?php endif; ?> 
                            </div>
                            <div class="row">
                                    <div class="col-12">
                                        <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                            </div>
                    <?php elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-12 order-1' && $question->imageposition == 'col-12 order-3'): ?>
                        <!-- Image(bottom) and question(center) and answer (top) -->
                        
                        <div class="row"> 
                            <div class="<?php echo e($aligment); ?>">
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        <div class="row">
                                <div class="col-12">
                                    <?php echo $question->question; ?>

                                </div>
                        </div>
                        <div class="row">
                            <?php if(filled($question->questionimage)): ?>
                                    <div class="col-12">
                                        <div class="<?php echo e($imagealigment); ?>">
                                            <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
                        </div>
                    <?php elseif($question->answerposition == 'col-12 order-3' && $question->imageposition == 'col-12 order-2'): ?>
                        <!-- Image(bottom) and question(center) and answer (top) -->
                        <div class="row">
                            <?php if(filled($question->questionimage)): ?>
                                <div class="col-12">
                                    <div class="<?php echo e($imagealigment); ?>">
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row"> 
                            <div class="<?php echo e($aligment); ?>">
                                <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        
                    <?php elseif($question->titlelocation == 'col-12 order-3' && $question->answerposition == 'col-12 order-1' && $question->imageposition == 'col-12 order-2'): ?>
                        <!-- Image(center) and question(bottom) and answer (top) -->
                        
                        <div class="row"> 
                            <div class="<?php echo e($aligment); ?>">
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        <div class="row">
                                <?php if(filled($question->questionimage)): ?>
                                    <div class="col-12">
                                        <div class="<?php echo e($imagealigment); ?>">
                                            <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                    
                        </div>
                        <div class="row">
                                <?php echo $question->question; ?>

                        </div>
                    <?php elseif($question->titlelocation == 'col-12 order-3' && $question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-8 order-1'): ?>
                        <!-- answer,image in same row but first answer,second image and quesion on top -->
                        
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="<?php echo e($aligment); ?>">
                                        <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if(filled($question->questionimage)): ?>
                            <div class="col-4">
                                <div class="<?php echo e($imagealigment); ?>">
                                    <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                </div>
                            </div>
                            <?php endif; ?>
                        
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <?php echo $question->question; ?>

                            </div>
                        </div>
                    <?php elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-12 order-3'): ?>
                        <!-- Image(bottom) and question(right) and answer (left) -->
                        <div class="row">
                            <div class="col-6">
                                    <div class="<?php echo e($aligment); ?>">
                                        <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                            </div>
                            <div class="col-6">
                                <?php echo $question->question; ?>

                            </div>
                        </div>
                        <?php if(filled($question->questionimage)): ?>
                        <div class="row">
                                <div class="col-12">
                                    <div class="<?php echo e($imagealigment); ?>">
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    </div>
                                </div>
                        </div>
                        <?php endif; ?>
                    <?php elseif($question->titlelocation == 'col-12 order-3' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-12 order-1'): ?>
                        <!-- Image(center) and question(bottom) and answer (top) -->
                        
                            <div class="row">
                                <?php if(filled($question->questionimage)): ?>
                                    <div class="col-12">
                                        <div class="<?php echo e($imagealigment); ?>">
                                            <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                    
                        </div>
                        <div class="row"> 
                            <div class="<?php echo e($aligment); ?>">
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <?php echo $question->question; ?>

                            </div>
                                
                        </div>
                    <?php elseif($question->imageposition == 'col-4 order-1' && $question->answerposition == 'col-8 order-2'): ?>
                        <!-- answer,image in same row but first image,second answer and quesion on top -->
                        <div class="row">
                            <?php if(filled($question->questionimage)): ?>
                            <div class="col-4">
                                <div class="<?php echo e($imagealigment); ?>">
                                    <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-8">
                                <div class="row">
                                    <div class="<?php echo e($aligment); ?>">
                                        <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif($question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-8 order-1'): ?>
                        <!-- answer,image in same row but first answer,second image and quesion on top -->
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="<?php echo e($aligment); ?>">
                                        <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if(filled($question->questionimage)): ?>
                            <div class="col-4">
                                <div class="<?php echo e($imagealigment); ?>">
                                    <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif($question->imageposition == 'col-12 order-3' && $question->answerposition == 'col-12 order-2'): ?>
                        <!-- answer center, image Bottom and quesion on top -->
                    
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="<?php echo e($aligment); ?>">
                                            <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php if(filled($question->questionimage)): ?>
                                <div class="col-12">
                                    <div class="<?php echo e($imagealigment); ?>">
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                    <?php elseif($question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-12 order-2'): ?>
                        <!-- answer,image in same row but first answer,second image and quesion on top -->
                        
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="<?php echo e($aligment); ?>">
                                            <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                </div>
                            <div>
                        
                            <?php if(filled($question->questionimage)): ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="<?php echo e($imagealigment); ?>">
                                            <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                    <?php elseif($question->imageposition == 'col-12 order-2' && $question->answerposition == 'col-12 order-3'): ?>
                    
                        <!-- answer,image in same row but first answer,second image and quesion on top -->
                        
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="<?php echo e($aligment); ?>">
                                            <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                </div>
                            <div>
                        
                            <?php if(filled($question->questionimage)): ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="<?php echo e($imagealigment); ?>">
                                            <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                    <?php endif; ?>
                    <?php
                        $content = json_decode($question->content);
                        $logic_content = json_decode($question->logic);
                    
                    ?>
                    <?php switch($question->titlelocation):
                        case ("default"): ?>
                            
                        <?php case ("deafult"): ?>
                        
                        <?php case ("left"): ?>
                            <?php
                                $left = 8;
                                $right = 4;
                                if($question->questionimage==null)
                                {
                                    $left=12;
                                    $right=12;
                                }
                            ?>
                            <div class="row">
                                <div class="col-md-<?php echo e($left); ?>">
                                <span class="q_number my-auto"><?php echo e($q_number++); ?></span>
                                    <h2 class="">
                                        <span class=""><?php echo $question->question; ?></span>
                                        
                                    </h2>
                                    <hr />
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="col-md-<?php echo e($right); ?> mt-2">
                                    <?php if(filled($question->questionimage)): ?>
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php break; ?>
                        <?php case ("hidden"): ?>
                            <?php
                                $left = 8;
                                $right = 4;
                                if($question->questionimage==null)
                                {
                                    $left=12;
                                    $right=12;
                                }
                            ?>
                            <div class="row">
                                <div class="col-md-<?php echo e($left); ?>">
                                <span class="q_number my-auto"><?php echo e($q_number++); ?></span>
                                <div class="row">
                                    <div class="col-10">
                                        <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    <div class="col-2">
                                        
                                    </div>
                                </div>
                                    
                                </div>
                                <div class="col-md-<?php echo e($right); ?> mt-2">
                                    <?php if(filled($question->questionimage)): ?>
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php break; ?>
                        <?php case ("right"): ?>
                            <?php
                                $left = 4;
                                $right = 8;
                                if($question->questionimage==null)
                                {
                                    $left=12;
                                    $right=12;
                                }
                            ?>
                            <div class="row">
                                <div class="col-md-<?php echo e($left); ?>">
                                    <?php if(filled($question->questionimage)): ?>
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-<?php echo e($right); ?>">
                                    <h2 class="d-inline-flex question-heading">
                                    
                                        <span class="q_number my-auto"><?php echo e($q_number++); ?></span>
                                        <span class=""><?php echo $question->question; ?></span>
                                        
                                    </h2>
                                    <hr />
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <?php break; ?>
                        <?php case ("top"): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="d-inline-flex question-heading">
                                    
                                        <span class="q_number my-auto"><?php echo e($q_number++); ?></span>
                                        <span class=""><?php echo $question->question; ?></span>
                                        
                                    </h2>
                                    <hr />
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="col-md-12">
                                    <?php if(filled($question->questionimage)): ?>
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php break; ?>
                        <?php case ("bottom"): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if(filled($question->questionimage)): ?>
                                        <img src="<?php echo e(asset('uploads/image/'. data_get($question->questionimage, 0))); ?>" width="<?php echo e($question->imagewidth); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12">
                                    <h2 class="d-inline-flex question-heading">
                                    
                                        <span class="q_number my-auto"><?php echo e($q_number++); ?></span>
                                        <span class=""><?php echo $question->question; ?></span>
                                        
                                    </h2>
                                    <hr />
                                    <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <?php break; ?>
                            
                        <?php endswitch; ?>
                
                    
                    
                    <div class="hidden-information">
                        <input type="hidden" class="qt_type" value="<?php echo e($question->questiontype); ?>">
                        <input type="hidden" class="logic_cnt" value="<?php echo e(count($logic_content)); ?>">
                    </div>
                    <input type="hidden" id="displayed_answer" value="0">
                    <?php for($k=0;$k< count($logic_content);$k++): ?>
                        <div class="logic_<?php echo e($k); ?>">
                            <input type="hidden" class="logic_type" value="<?php echo e($logic_content[$k][0]); ?>">
                            <input type="hidden" class="logic_qt" value="<?php echo e($logic_content[$k][1]); ?>">
                            <input type="hidden" class="logic_operator" value="<?php echo e($logic_content[$k][2]); ?>">

                            <?php if( is_array($logics = data_get($logic_content, [$k,3])) ): ?>
                                <?php $__currentLoopData = $logic_content[$k][3]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" class="<?php echo e('logic_cont '.$key); ?>" name="logic_cont[]" value="<?php echo e($value); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <input type="hidden" class="logic_state" value="0">
                        </div>
                    <?php endfor; ?>
                    
                </div>
                </form>
                
            </div>
            
        <?php else: ?>
            <div 
                id="q_<?php echo e($question->id); ?>" 
                class="question-card card custom-card mb-3 p-2" data-page="<?php echo e($question->page_number); ?>" 
                style="
                    background-color:<?php echo e($question->question_bg_color ?? '#fff'); ?>;
                    box-shadow: 1px 1px 6px <?php echo e(($question->question_bg_color != '' && $question->question_bg_color != '#fff')?'2px':'-3px'); ?>  <?php echo e(($question->question_bg_color != '' && $question->question_bg_color != '#fff')?$question->question_bg_color:'#000'); ?>;
                ">
                
                <form id="checkForm">
                    <div class="row">
                        <input type='hidden' value='<?php echo e($q_number); ?>' id='quesno<?php echo e($question->id); ?>' />
                        <div class="p-0">
                            <span 
                                class="q_number gradient-bg my-auto" 
                                style="
                                    color: <?php echo e($LessonFirstColor); ?>;
                                    background: <?php echo e($lesson->color1); ?>;
                                    font-size: <?php echo e($LessonFirstFontSize); ?>;
                                    font-style: <?php echo e($firstStyle1); ?>;
                                    font-family: <?php echo e($LessonFontFamily); ?>;
                                "
                            >
                                <?php echo e($q_number++); ?>

                            </span>
                        </div>

                        <div 
                            class="p-0 pl-2 curserPointQue d-flex" 
                            style="
                                flex: 1; 
                                line-height: 2.5rem;
                                
                                justify-content: <?php echo e(data_get($question->layout_properties, 'description.align', 'left')); ?>;
                                align-items: baseline;
                            "
                        >
                            <?php if($question->titlelocation == 'default'): ?>
                                <p>
                                    <?php echo $question->question; ?>

                                </p>
                            <?php endif; ?>
                            <?php 
                                $chartIdPart = extractChartId(html_entity_decode($question->question)); 
                            ?>
                        </div>
                        
                        <?php if(!$question->required): ?>
                            <?php
                                $col = 4;
                            ?>
                        <?php else: ?>
                            <?php
                                $col = 2;
                            ?>
                        <?php endif; ?>

                        <?php 
                            if(isset($question->answer_aligment)){
                                if(($question->answer_aligment == 'offset-md-0')){
                                    $aligment = 'col-12 '.$question->answer_aligment;
                                }else{
                                    $aligment = $question->answer_aligment;
                                }
                            }else{
                                $aligment = 'col-12';
                            }  
                            if(isset($question->image_aligment)){
                                if(($question->image_aligment == 'offset-md-0')){
                                    $imagealigment = 'col-12 '.$question->image_aligment;
                                }else{
                                    $imagealigment = $question->image_aligment;
                                }
                            }else{
                                $imagealigment = 'col-12';
                            }
                        ?>

                        <div class="p-0 d-flex align-items-center justify-content-end">
                            <?php if($question->help_info != "" && $question->access_help_info == 1): ?>
                                <span 
                                    data-toggle="modal"
                                    data-target="#helpModel"
                                    onclick='getHelpForModel(<?php echo e($question->id); ?>, "<?php echo e($question->color2); ?>")'
                                    style="
                                        position: relative;
                                        margin-left: -30px; 
                                        margin-top: -5px;

                                        color: <?php echo e($LessonFirstColor); ?>;
                                        font-size: <?php echo e($LessonFirstFontSize); ?>;
                                        font-style: <?php echo e($firstStyle1); ?>;
                                        font-family: <?php echo e($LessonFontFamily); ?>;
                                        border-radius: 90% !important;
                                        z-index: 1;
                                    "
                                    class="d-flex mr-2"
                                >
                                    <span style="z-index: 10;">?</span>
                                    
                                    <div
                                        style="
                                            height: 100%;
                                            left: -100%;
                                            position: absolute;
                                            background-color: <?php echo e($lesson->color1); ?>;
                                            width: calc(<?php echo e($LessonFirstFontSize); ?> + 10px);
                                            border-radius: 90% !important;
                                            z-index: 1;
                                        "
                                    ></div>
                                </span>
                            <?php endif; ?>
                            <?php echo $__env->make('frontend.components.questions.required', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="card-body p-0 border-top mt-2">

                        <?php if (isset($component)) { $__componentOriginal1c67ed83f202423647d27d5fb8f8a06b248d1833 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Fontend\Questions::class, ['question' => $question,'content' => $content]); ?>
<?php $component->withName('fontend.questions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c67ed83f202423647d27d5fb8f8a06b248d1833)): ?>
<?php $component = $__componentOriginal1c67ed83f202423647d27d5fb8f8a06b248d1833; ?>
<?php unset($__componentOriginal1c67ed83f202423647d27d5fb8f8a06b248d1833); ?>
<?php endif; ?>

                        
                        <?php
                            $content = json_decode($question->content);
                            $logic_content = json_decode($question->logic);
                        
                        ?>

                        
                        
                        
                        <div class="hidden-information">
                            <input type="hidden" class="qt_type" value="<?php echo e($question->questiontype); ?>">
                            <input type="hidden" class="logic_cnt" value="<?php echo e(count($logic_content)); ?>">
                        </div>
                        <input type="hidden" id="displayed_answer" value="0">
                        <?php for($kindex=0;$kindex< count($logic_content);$kindex++): ?>
                            <div class="logic_<?php echo e($kindex); ?>">
                                <input type="hidden" class="logic_type" value="<?php echo e($logic_content[$kindex][0]); ?>">
                                <input type="hidden" class="logic_qt" value="<?php echo e($logic_content[$kindex][1]); ?>">
                                <input type="hidden" class="logic_operator" value="<?php echo e($logic_content[$kindex][2]); ?>" />
                                <?php if(is_array($logic_content[$kindex][3])): ?>
                                    <?php $__currentLoopData = $logic_content[$kindex][3]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="hidden" class="<?php echo e('logic_cont '.$key); ?>" name="logic_cont[]" value="<?php echo e($value); ?>" />
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <input type="hidden" class="logic_cont" name="logic_cont[]" value="<?php echo e($logic_content[$kindex][3]); ?>" />
                                <?php endif; ?>
                                <input type="hidden" class="logic_state" value="0">
                            </div>
                        <?php endfor; ?>
                        
                    </div>
                </form>
                
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<div id="textresult"></div>
<div class="report-card card mt-2" style="display: none;">
    <div class="card-body">
        <div id="report">
            
        </div>
    </div>
</div>
<!-- Add the loading spinner HTML element -->
<div id="loader" class="text-center" style="display: none;">
  <!-- Spinning icon from Font Awesome -->
  <p>
  <i class="fas fa-spinner fa-spin"></i>
  <br>
  <?php if(config('access.users.order_mail') == 1): ?>
    Sending report to your email, Please wait..
    <?php else: ?>
    Reports are generating, please do not refresh or return to the page until done.
    Once completed, you can see the PDF in the side menu.
    <?php endif; ?>
  </p>
<!--   <p>
    I rapporti vengono generati, quindi non aggiornare o tornare alla pagina fino al completamento.
    Una volta completato, è possibile visualizzare il PDF nel menu laterale.
  </p> -->
</div>
<div class="text-right">
    <div id="navigation-btns" class="mb-2" style="">
        <button type="button" id="pre-pg" class="btn btn-danger">Previous</button>
        <button type="button" id="next-pg" class="btn btn-danger">Next</button>
    </div>
    
    <div class="buttons-genius">
        <div class="genius-btn mt60  ml-auto custom-btn" id="report_div">
            <?php
                preg_match('/font-size:(\d+px)/', $text2, $matches);
                $firstFontSize = $matches[1] ?? null;
                preg_match('/font-style:([^;]*)/', $text2, $matches1);
                $firstStyle = $matches1[1] ?? null;
                preg_match('/font-family:([^;]*)/', $text2, $matches2);
                $firstFamily = $matches2[1] ?? null;
            ?>
            <a 
                id="answer_submit"
                href="javascript:void(0);"
                class="btn btn-lesson lesson-font"
            >
                Report
            </a>

            <button id="create-reports" class="hidden"></button>
        </div>
        <div class="genius-btn mt60  ml-auto custom-btn" id="update_report_div" >
            <a 
                id="update-report" 
                href="javascript:void(0);" 
                class="btn btn-lesson lesson-font"
            >
                Save Report
            </a>
        </div>
    </div>
    
</div>
<div class="modal fade" id="helpModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-white">
            <div class="modal-header backgroud-style p-0">
                <div class="gradient-bg"></div>
                <div class="popup-logo">
                    <img src="<?php echo e(asset('storage/logos/popup-logo.png')); ?>" alt="">
                </div>
                <div class="popup-text text-center p-2">
                    <h2 class="mt-5">Guida</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div id="modelHelp"></div>
                <div class="nws-button text-right white text-capitalize">
                    <button type="button"  style="height:unset;width:unset;font-size:1.2rem;" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('after-scripts'); ?>
<script src="<?php echo e(asset('/plugins/amcharts_4/core.js')); ?>"></script>
<script src="<?php echo e(asset('/plugins/amcharts_4/charts.js')); ?>"></script>
<script src="<?php echo e(asset('/plugins/amcharts_4/themes/material.js')); ?>"></script>
<script src="<?php echo e(asset('/plugins/amcharts_4/themes/animated.js')); ?>"></script>
<script src="<?php echo e(asset('/plugins/amcharts_4/themes/kelly.js')); ?>"></script>
<script src="<?php echo e(asset('js/pie-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/bar-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/d3bar-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/donut-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/horizontal-bar.js')); ?>"></script>
<script src="<?php echo e(asset('js/line-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/radar-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/polar-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/bubble-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/radar1-chart.js')); ?>"></script>
<script src="<?php echo e(asset('js/responsive-table.js')); ?>"></script>
<script src="<?php echo e(asset('js/sortable-table.js')); ?>"></script>
<script src="<?php echo e(asset('js/no-table-chart.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?php echo e(asset('js/utils.js')); ?>"></script>

<?php
    $temp=explode('style="',$lesson->text1);
    $btnstyle="";
    foreach($temp as $index)
        if(strrpos($index,'"')>0)
            $btnstyle=$btnstyle.substr($index,0,strrpos($index,'"')).';';
?>
<script>
    
      function ExpressionCalculation(content=[], user_question=[]) {
        if(!content) {
            content = [];
        }

        for (var i = 1; i < content.length; i++) {
            for (var j = 1; j < content[i].length; j++) {
                var expression = [];
                expression = equation_extraction(content[i][j]);
                var infix_expression = expression;//infixToPostFix(expression);

                for (var k = 0; k < infix_expression.length; k++) {
                    if(infix_expression[k] == undefined || infix_expression[k] == "" || infix_expression[k] == null)
                        continue;
                    if (infix_expression[k].includes("question") == true) {
                        var q_item = infix_expression[k].split("question")[1];
                        for (var m = 0; m < user_question.length; m++) {
                            if (user_question[m]['q_id'] == q_item) {
                                infix_expression[k] = user_question[m]['score'];
                                break;
                            }
                            else
                                infix_expression[k] = 0;
                        }
                    }else if (infix_expression[k].includes("textgroup") == true) {
                        var t_item = infix_expression[k].split("textgroup")[1];
                        for (var m = 0; m < textgroup_scores.length; m++) {
                            if (textgroup_scores[m]['id'] == t_item) {
                                infix_expression[k] = textgroup_scores[m]['score'];
                                break;
                            }
                        }
                    }else if(infix_expression[k].includes("file") == true){
                        var q_item = infix_expression[k].split(".")[0];
                        var file_id = infix_expression[k].split(".")[2] - 1;
                        for(var m = 0; m < user_question.length; m++){
                            if(user_question[m]['q_id'] == q_item) {
                                files = JSON.parse(user_question[m]['answer']);
                                infix_expression[k] = file_element(files[file_id]);
                            }
                        }
                    }else{
                        let names = infix_expression[k].split(".");
                        if(names.length >= 3){
                            let num = names.length - 1;
                            $("table[name='matrix']").each(function (idx, ele) {
                                let id = $(this).data("id");
                                if(id === parseInt(names[0])){
                                    var value = 0;
                                    let input = $(this).find("input[id='q_id" + names[num] + "']");
                                    var row = $(input).parent().parent();
                                    let inputs = $(row).children().find('input[type="radio"]');
                                    if(inputs.length == 0){
                                        // inputs = $(row).children().find('input[type="text"]');
                                        // for(var i = 0; i < inputs.length; i++){
                                            value = $(input).val();
                                        // }
                                    }else {
                                        for(var i = 0; i < inputs.length; i++){
                                            if($(inputs[i]).is(':checked')){
                                                value = $(inputs[i]).val();
                                                break;
                                            }
                                        }
                                    }
                                    
                                    if(value == "" || value == null)
                                        value = 0;
                                    value = parseInt(value);
                                    infix_expression[k] = value;
                                }
                            })

                        }
                    }
                }

                content[i][j] = infix_expression;
                //console.log(infix_expression);
            }
        }
        for (var i = 1; i < content.length; i++) {
            for (var j = 1; j < content[i].length; j++) {
                content[i][j] = infix_evaluation(content[i][j]);
            }
        }
        return content;
    }

    function equation_extraction(origin_expression) {
        origin_expression=origin_expression.replace(",",".");
        var operator = ["+", "-", "*", "/", "(", ")"];
        var expression = [];
        expression[0] = "";
        var i = 0;
        var operator_flag = 0;
        for (var t = 0; t < origin_expression.length; t++) {
            operator_flag = 0;
            for (var j = 0; j < operator.length; j++) {
                if (origin_expression[t] == operator[j]) {
                    operator_flag = 1;
                    break;
                }
            }
            if (operator_flag == 0)
                expression[i] += origin_expression[t];
            else {
                if (expression[i].length > 0)
                    i++;
                expression[i] = operator[j];
                if (t != origin_expression.length - 1) {
                    i++;
                    expression[i] = "";
                }
            }

        }
        return expression;
    }

    function infix_evaluation(infix_expression) {
        var temp = [];
        let cnx = "";
        for( let j = 0; j < infix_expression.length; j++){
            cnx += infix_expression[j];
        }
        if(cnx.includes('<div') == true) {
            let formula = cnx;
            return formula;
        }
        cnx = cnx.replace("++", "+");
        cnx = cnx.replace("+*", "*");
        cnx = cnx.replace("+-", "-");
        cnx = cnx.replace("+/", "/");
        cnx = cnx.replace("-*", "*");
        cnx = cnx.replace("--", "-");
        cnx = cnx.replace("-+", "+");
        cnx = cnx.replace("-/", "/");
        cnx = cnx.replace("**", "*");
        cnx = cnx.replace("*-", "-");
        cnx = cnx.replace("*+", "+");
        cnx = cnx.replace("*/", "/");
        cnx = cnx.replace("/*", "*");
        cnx = cnx.replace("/-", "-");
        cnx = cnx.replace("/+", "+");
        cnx = cnx.replace("//", "/");
        cnx = cnx.replace("(+", "(");
        //cnx = cnx.replace(")+", ")");
        cnx = cnx.replace("(*", "(");
        //cnx = cnx.replace(")*", ")");
        cnx = cnx.replace("(-", "(");
        //cnx = cnx.replace(")-", ")");
        cnx = cnx.replace("(/", "(");
        cnx = cnx.replace("/)", ")");
        try {
            let formula = eval(cnx);
            return formula;
        }catch(e){
            return cnx;
        }

    }

    function drawChart(contents, chartids, types,idx) {
        types = types ?? [];
        // let idx = 1;
        for(let j = 0; j < contents.length; j++) {
            let content = contents[j];
            if (types[j] == 0) {
                pie_chart_draw(content, idx);
            } else if (types[j] == 1) {
                donut_chart_draw(content, idx);
            } else if (types[j] == 2) {
                bar_chart_draw(content, idx);
            } else if (types[j] == 3) {
                d3bar_chart_draw(content, idx);
            } else if(types[j] == 5) {
                horizontal_bar_chart_draw(content, idx);
            } else if(types[j] == 6) {
                line_chart_draw(content, idx);
            } else if(types[j] == 7) {
                radar_chart_draw(content, idx);
            } else if(types[j] == 8) {
                polar_chart_draw(content, idx);
            } else if(types[j] == 9) {
                bubble_chart_draw(content, idx);
            } else if(types[j] == 11) {
                radar1_chart_draw(content, idx);
            } else if(types[j] == 4) {
                sortable_table_draw(content,idx);
                set_table_format(idx,chartids[j],1);
            } else if(types[j] == 10) { //resonsive table
                responsive_table_draw(content,idx);
                set_table_format(idx,chartids[j],2);
            } else if(types[j] == 12){ // no table and chart
                noTableAndChartDraw(content,chartids[j] , idx,j);
            } else if(types[j] == 13){ // HORIZONTAL //////////////////////////////////////////////////
                horizontal_draw(content,chartids[j] , idx);
            } else if(types[j] == 14){ // stacked
                stacked_draw(content,chartids[j] , idx);
            } else if(types[j] == 15){ // vertical
                vertical_draw(content,chartids[j] , idx);
            } else if(types[j] == 16){ // line
                line_draw(content,chartids[j] , idx);
            } else if(types[j] == 17){ // point-styling
                point_styling_draw(content,chartids[j] , idx);
            } else if(types[j] == 18){ // bubble
                bubble_draw(content,chartids[j] , idx);
            } else if(types[j] == 19){ // combo-bar-line
                combo_bar_line_draw(content,chartids[j] , idx);
            } else if(types[j] == 20){ // doughnut
                doughnut_draw(content,chartids[j] , idx);
            } else if(types[j] == 21){ // multi-series-pie
                multi_series_pie_draw(content, chartids[j] ,idx);
            } else if(types[j] == 22){ // pie
                pie_draw(content,chartids[j] , idx);
            } else if(types[j] == 23){ // polar-area
                polar_area_draw(content, chartids[j] ,idx);
            } else if(types[j] == 24){ // radar
                radar_draw(content,chartids[j] , idx);
            } else if(types[j] == 25){ // scatter
                scatter_draw(content,chartids[j] , idx);
            } else if(types[j] == 26){ // area-radar
                area_radar_draw(content,chartids[j] , idx);
            } else if(types[j] == 27){ // line-stacked
                line_stacked_draw(content, idx);
            }
            // idx++;
        }
       
    }
    let contents = [];
    let helpArray = [];
    function getHelp(){
        <?php
            $questionIds = $lesson->questions->pluck('id');
        ?>
        let qustId = '<?php echo e($questionIds); ?>'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"get",
            url:`<?php echo e(route('user.get-help')); ?>`,
            data:{qustId:qustId},
            async: false,
            success: function (response) {
                var helpData = JSON.parse(response);
                var idx = 1;
                for(var i = 0; i < helpData.length; i++) {
                    let contents = [];
                    let value = helpData[i];
                    var helpInfoValue = value.content;
                    if(value.step == 2){
                        var chart_val = value.chartid;
                        var chart_type = value.type;
                        if (chart_type == 0) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="pie-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type === "1") {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="donut-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type === "2") {
                            $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="bar-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type === "3") {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="d3bar-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 5) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="horizontal-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 6) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="line-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 7) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="radar-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 8) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="polar-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 9) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="bubble-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 11) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="radar1-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 4) { //sortable table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="sortable_table' + idx + '" ><table class="table table-stried table-bordered table-sm" cellspacing="0" width="100%"></table></div></div></p></div>');
                        } else if (chart_type == 10) { //responsive table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="responsive_table' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 12) { //no chart and table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><span id="no_table_chart' + idx + '" class="col-12 no-table-chrt"></span></div></p></div>');
                        } else if (chart_type == 13) { //horizontal table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 14) { //stacked table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 15) { //vertical table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 16) { //line table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 17) { //point styling table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 18) { //bubble table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 19) { //combo-bar-line table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 20) { //doughnut table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 21) { //multi-series-pie table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 22) { //pie table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 23) { //polar-area table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 24) { //radar table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 25) { //scatter table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 26) { //area-radar table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 27) { //line-stacked table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        }
                        var content = JSON.parse(value.content);
                        contents.push(ExpressionCalculation(content, value.question));
                        drawChart(contents,value.chartid,value.type,idx);
                    }else{
                        $(".helpDiv").append(helpInfoValue);
                    }
                    idx++;
                }
                setTimeout(function() {
                    // Your code here will run after a 5 second delay.
                    var fsize = "<?php echo $firstFontSize; ?>";
                    var fstyle = "<?php echo $firstStyle; ?>";
                    var fFamily = "<?php echo $firstFamily; ?>";

                    $('.setStyleDiv').css('font-size', ''+fsize+'');
                    $('.setStyleDiv').css('font-style', ''+fstyle+'');
                    $('.setStyleDiv').css('font-family', ''+fFamily+'');
                    
                }, 2000);
                
            },
            error: function (error) {
                var err = error.responseText;
                console.log(err);
            }
        })
    }

    function getHelpForModel(id, color){
        let qustId = '['+id+']'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"get",
            url:`<?php echo e(route('user.get-help-model')); ?>`,
            data:{qustId:qustId},
            async: false,
            success: function (response) {
                var helpData = JSON.parse(response);
                var idx = 1;
                for(var i = 0; i < helpData.length; i++) {
                    let contents = [];
                    let value = helpData[i];
                    var helpInfoValue = value.content;
                    if(value.step == 2){
                        var chart_val = value.chartid;
                        var chart_type = value.type;
                        if (chart_type == 0) {
                           $("#modelHelp").html('<div id="pie-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "1") {
                           $("#modelHelp").html('<div id="donut-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "2") {
                            $("#modelHelp").html('<div id="bar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "3") {
                           $("#modelHelp").html('<div id="d3bar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 5) {
                           $("#modelHelp").html('<div id="horizontal-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 6) {
                           $("#modelHelp").html('<div id="line-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 7) {
                           $("#modelHelp").html('<div id="radar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 8) {
                           $("#modelHelp").html('<div id="polar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 9) {
                           $("#modelHelp").html('<div id="bubble-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 11) {
                           $("#modelHelp").html('<div id="radar1-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 4) { //sortable table
                           $("#modelHelp").html('<div id="sortable_table' + idx + '" ><table class="table table-stried table-bordered table-sm" cellspacing="0" width="100%"></table></div>');
                        } else if (chart_type == 10) { //responsive table
                           $("#modelHelp").html(' <div id="responsive_table' + idx + '" ></div>');
                        } else if (chart_type == 12) { //no chart and table
                           $("#modelHelp").html(' <span id="no_table_chart' + idx + '" class="col-12 no-table-chrt"></span>');
                        } else if (chart_type == 13) { //horizontal table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 14) { //stacked table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 15) { //vertical table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 16) { //line table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 17) { //point styling table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 18) { //bubble table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 19) { //combo-bar-line table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 20) { //doughnut table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 21) { //multi-series-pie table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 22) { //pie table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 23) { //polar-area table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 24) { //radar table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 25) { //scatter table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 26) { //area-radar table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 27) { //line-stacked table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        }
                        var content = JSON.parse(value.content);
                        contents.push(ExpressionCalculation(content, value.question));
                        drawChart(contents,value.chartid,value.type,idx);
                    }else{
                        var fsize = "<?php echo $firstFontSize; ?>";
                        var fstyle = "<?php echo $firstStyle; ?>";
                        var fFamily = "<?php echo $firstFamily; ?>";
                        $("#modelHelp").html(helpInfoValue);
                        // $(".modelTextStyle").css('font-size','20');

                        // $('.modelTextStyle').css('color',color);
                        $('.modelTextStyle').css('font-size', ''+fsize+'');
                        $('.modelTextStyle').css('font-style', ''+fstyle+'');
                        $('.modelTextStyle').css('font-family', ''+fFamily+'');
                    }
                    idx++;
                }
                
            },
            error: function (error) {
                var err = error.responseText;
                console.log(err);
            }
        })
    }

    function getQustionGraph(id){
        let qustId = '['+id+']'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"get",
            url:`<?php echo e(route('user.get-graph')); ?>`,
            data:{qustId:qustId},
            async: false,
            success: function (response) {
                var helpData = JSON.parse(response);
                var idx = 1;
                for(var i = 0; i < helpData.length; i++) {
                    let contents = [];
                    let value = helpData[i];
                    var helpInfoValue = value.content;
                    if(value.step == 2){
                        var chart_val = value.chartid;
                        var chart_type = value.type;
                        if (chart_type == 0) {
                           $("#dynamic_chart"+id).html('<div id="pie-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "1") {
                           $("#dynamic_chart"+id).html('<div id="donut-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "2") {
                            $("#dynamic_chart"+id).html('<div id="bar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "3") {
                           $("#dynamic_chart"+id).html('<div id="d3bar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 5) {
                           $("#dynamic_chart"+id).html('<div id="horizontal-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 6) {
                           $("#dynamic_chart"+id).html('<div id="line-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 7) {
                           $("#dynamic_chart"+id).html('<div id="radar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 8) {
                           $("#dynamic_chart"+id).html('<div id="polar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 9) {
                           $("#dynamic_chart"+id).html('<div id="bubble-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 11) {
                           $("#dynamic_chart"+id).html('<div id="radar1-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 4) { //sortable table
                           $("#dynamic_chart"+id).html('<div id="sortable_table' + idx + '" ><table class="table table-stried table-bordered table-sm" cellspacing="0" width="100%"></table></div>');
                        } else if (chart_type == 10) { //responsive table
                           $("#dynamic_chart"+id).html(' <div id="responsive_table' + idx + '" ></div>');
                        } else if (chart_type == 12) { //no chart and table
                           $("#dynamic_chart"+id).html(' <span id="no_table_chart' + idx + '" class="col-12 no-table-chrt"></span>');
                        } else if (chart_type == 13) { //horizontal table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 14) { //stacked table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 15) { //vertical table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 16) { //line table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 17) { //point styling table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 18) { //bubble table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 19) { //combo-bar-line table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 20) { //doughnut table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 21) { //multi-series-pie table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 22) { //pie table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 23) { //polar-area table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 24) { //radar table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 25) { //scatter table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 26) { //area-radar table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 27) { //line-stacked table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        }
                        var content = JSON.parse(value.content);
                        contents.push(ExpressionCalculation(content, value.question));
                        drawChart(contents,value.chartid,value.type,idx);
                    }else{
                        $("#dynamic_chart"+id).html(helpInfoValue);
                    }
                    idx++;
                }
                
            },
            error: function (error) {
                var err = error.responseText;
                console.log(err);
            }
        })
    }


    function convertNumberFormat(inputValue) {
        var replacedValue = inputValue.replace(/,/g, '#'); // Replace all commas with a temporary character '#'
        replacedValue = replacedValue.replace(/\./g, ','); // Replace all periods with commas
        replacedValue = replacedValue.replace(/#/g, ','); // Replace all temporary characters '#' with periods

        return replacedValue;
    }
    
    function inputToData(ele){
        if(ele.type == 'radio'){
            $('.radioselected').each(function(el){
                $(this).removeClass('selected');
                $(this).attr('data-selected','false');
            });
            $(ele).addClass('selected');
            $(ele).attr('data-selected','true');
        }else{
            
            if(!isNaN(ele.value)){
                ele.value=Number(ele.value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
            var italicFrom  = convertNumberFormat(ele.value);
            // alert(ele)
            // console.log(italicFrom);
            $(ele).data('value',italicFrom);
            $(ele).val(italicFrom);
            $('.q_id'+ele.dataset.q_id).data('value',italicFrom);
        }
    }
    $("body").append(`<style>#create-report {<?php echo $btnstyle;?>}</style>`)
    var el=$(".q_number")[0];
    var size=parseFloat(window.getComputedStyle(el, null).getPropertyValue('font-size'))+10;
    console.log(size);
    $("body").append(`<style>.q_number{width:${size}px;height:${size}px;line-height:${size}px;}</style>`)
    var len=$(".img_canvas").length;
    var style = window.getComputedStyle(el);
    function getRGB(str){
      var match = str.match(/rgb?\((\d{1,3}), ?(\d{1,3}), ?(\d{1,3})\)?(?:, ?(\d(?:\.\d?))\))?/);
      return match ? {
        red: match[1],
        green: match[2],
        blue: match[3]
      } : {};
    }
    for(var i=0;i<len;i++)
    {
        var img = new Image();
        img.crossOrigin = "anonymous";
        img.src = "../../storage/logos/help.png";
        var canvas = $(".img_canvas")[i];
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img,29, 35);
        img.style.display = "none";
        var width = img.width;
        var height = img.height;
        for(var j=0;j<canvas.width;j++)
            for(var k=0;k<canvas.height;k++)
            {
                var pixel = ctx.getImageData(j, k, 1, 1);
                var data = pixel.data;
                {
                    pixel.data[0]=getRGB(style.backgroundColor)['red'];
                    pixel.data[1]=getRGB(style.backgroundColor)['green'];
                    pixel.data[2]=getRGB(style.backgroundColor)['blue'];
                }   
                
                ctx.putImageData(pixel,j,k);
            }
    }
</script>
<script type="text/javascript">
    getQustionGraph(<?php echo e($question->id); ?>);

    $('.question-box').on('mouseover', function({ currentTarget, clientY, ...event }) {
        const targetPosition = currentTarget.getBoundingClientRect();
        const left = targetPosition.left + targetPosition.width + 5;

        const hint = this.dataset.hint ?? null; 

        $('.hint-content').html(hint);

        if($('.hint-content').text().trim().length) {
            $('.hint-box').show();
            
            const top = Math.min(
                clientY, 
                targetPosition.height + targetPosition.top - $('.hint-box').height() - 5
            );

            $('.hint-box').css({
                'left': left,
                'top': top
            })
        }
    });

    $('.question-box').on('mouseleave', function() { 
        $('.hint-content').html(null);

        setInterval(() => {
            if($('.hint-content').text().trim().length <= 0) {
                $('.hint-box').hide();
            }
        }, 100);
    })
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/questions.blade.php ENDPATH**/ ?>