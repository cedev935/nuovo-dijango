
<?php
if(isset($firstFontSize)){
    $firstFontSize = $firstFontSize;
}else{
    $firstFontSize = '';
}

if(isset($firstStyle)){
    $firstStyle = $firstStyle;
}else{
    $firstStyle = '';
}

if(isset($firstFamily)){
    $firstFamily = $firstFamily;
}else{
    $firstFamily = '';
}

?>
<div class="single-input">
    <div class="mb-2">
        <input type="text" class="form-control" id="{{$question->id}}" name="single_input[]" placeholder="Write your answer" @if($question->required) required @endif style="<?php 
            if(isset($question)){
            $cont=$question->content;
            $obj = json_decode($cont,true);
            
            $width="";
            $height="";

            if(isset($obj[0]["width"])==false)
                $width="fit-content";
            else{
                if(($obj[0]["width"])=="")
                    $width="fit-content";
                else $width=$obj[0]["width"];
            }

            if(isset($obj[0]["height"])==false)
                $height="fit-content";
            else{
                if(($obj[0]["height"])=="")
                    $height="fit-content";
                else $height=$obj[0]["height"];
            }
            echo "width:".$width.";height:".$height.";border-color:".$question->color1.";color:".$question->color2."; font-size:$firstFontSize;font-style:$firstStyle;font-family:$firstFamily;";

          }

        ?>">
        <span class="message mt-2"></span>
    </div>
    <div class="more_answers">
    </div>
    <!-- @if($question->more_than_one_answer==1)
        <div class="genius-btn mt60 gradient-bg ml-auto custom-btn">
            <a href="javascript:void(0);" class="btn-add-answer">Add another answer</a>
        </div>
    @endif -->
</div>