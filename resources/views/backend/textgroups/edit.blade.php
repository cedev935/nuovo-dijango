@extends('backend.layouts.app')
@section('title', __('labels.backend.textgroups.title').' | '.app_name())
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/textgroup.css')}}" />
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <input type="hidden" id="textgroup_id" value="{{ $current_textgroup->id }}" />
            <h3 class="page-title float-left mb-0">Textgroup Edit</h3>
            <div class="float-right">
                <a 
                    href="{{ route('admin.textgroups.index', ['course_id' => request('course_id'), 'test_id'=>request('test_id')]) }}" 
                    class="btn btn-success"
                >
                    <i class="fa fa-list-ul"></i> @lang('labels.backend.textgroups.view')
                </a>
            </div>         
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row form-group">
                        {!! Form::label('course_id', trans('labels.backend.tests.fields.course'), ['class' => 'col-md-2 form-control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::select('course_id', $courses, request('course_id', old('course_id')), ['class' => 'form-control select2']) !!}
                        </div>
                    </div>    
                    <div class="row form-group">
                        {!! Form::label('tests_id', 'Test List *', ['class' => 'col-md-2 form-control-label']) !!}
                        <div class="col-md-10">
                            <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                                @foreach($tests as $test)
                                    @if (in_array(intval($test->id), $test_ids))
                                        <option value="{{$test->id}}" selected>{{strip_tags($test->title)}}</option>                             
                                    @else
                                        <option value="{{$test->id}}">{{strip_tags($test->title)}}</option>                             
                                    @endif
                                @endforeach  
                            </select> 
                        </div>
                    </div>
                    <div class="row form-group has-info">
                        {!! Form::label('title', 'Title *', ['class' => 'col-md-2 form-control-label']) !!}
                        <div class="col-md-10">
                            <input id="title" type="text" class="form-control required" value="{{$current_textgroup->title}}" />
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
<div class="row text m-2 p-2 pb-3" id="text_{{ $i }}">
    <div class="col-12 form-group content-box">
        <div class="form-group form-md-line-input">                   
            <label class="control-label pl-2">Text *</label> 
            <textarea class="form-control text_msg" rows="2" placeholder="Please input the Text...">
                {{ $content[$i] }}
            </textarea>   
        </div>
        <div class="form-group row">
            <label class="control-label col-md-2">Score *</label>  
            <div class="col-md-10">  
                <input class="form-control text_score" type="number" value="{{ $score[$i] }}" />  
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
        <div class="row mt-3 condition" id="condition_{{ $i }}_{{ $j }}">
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
                    <span class="type-{{ $qa->questiontype }}"><i class="fa fa-folder"></i></span> {{ $qa->id .'. '. strip_tags($qa->question) }} - <span>[{{ $qtypes[$qa->questiontype] }}]</span>{!! $score_htm.$is_condition_logic !!}
                </div>
                <div class="logic_tree" style="display:none">
                    <ul class="treecontent">
                        @for ($q=0; $q<count($course_list); $q++)
                        <li>                  
                        {{ $course_list[$q]['title'] }}
                            <ul>
                                @for ($r=0; $r<count($course_test_list[$q]); $r++)
                                    <li>
                                        {{ $course_test_list[$q][$r]['title']}}
                                        <ul>
                                            <?php
                                                $tk=  $course_test_list[$q][$r]['id'];
                                            ?>
                                            @if(isset($question_list[$tk]))
                                                @foreach ($question_list[$tk] as $question_item)
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
                                                    @if ($question_item['id'] == $logic[$i][$j][1])
                                                        <li class="type-{{ $question_item['questiontype'] }} jstree-clicked">{{ $question_item['id'] .'.'. strip_tags($question_item['question']) }} <span>[{{ $qtypes[$question_item['questiontype']] }}]</span>{!! $score_htm.$is_condition_logic !!}</li>
                                                    @else
                                                        <li class="type-{{ $question_item['questiontype'] }}">{{ $question_item['id'] .'.'. strip_tags($question_item['question']) }} <span>[{{ $qtypes[$question_item['questiontype']] }}]</span>{!! $score_htm.$is_condition_logic !!}</li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                @endfor
                            </ul>
                        </li>                                     
                        @endfor
                    </ul>                   
                </div>
            </div>
            <input class="qt_type" type="hidden" value="{{ $qa->questiontype }}" />
            <div class="col-sm-2">                                    
                <select class="form-control btn-warning operators" name="operators" placeholder="Options">
                    <?php for($k=0; $k<count($operators); $k++) { ?>
                        @if ($logic[$i][$j][2]==$k)
                            <option value="{{ $k }}" selected>{{ $operators[$k] }}</option>
                        @else
                            <option value="{{ $k }}">{{ $operators[$k] }}</option>
                        @endif
                    <?php } ?>                                       
                </select>
            </div>
            <div class="col-12 logic-content">
                @if($qa->questiontype == 1)
                    <div class="row  main-content" id="cond_{{$qa->id}}"  > 
                        <div class="col-12 form-group logic_check">
                            @for($num= 0; $num < count($question_info) - 2; $num++)
                            <?php
                                $check_vals = json_decode($logic[$i][$j][3]);
                            ?>
                                <div class="checkbox">
                                    @if ( data_get($question_info, [$num, 'score']) == $check_vals)
                                        <label><input type="checkbox" class="checkbox_{{ $num }} check_box_q" value="{{data_get($question_info, [$num, 'score'])}}" checked>{{ data_get($question_info, [$num, 'label']) }}</label>
                                    @else
                                        <label><input type="checkbox"  class="checkbox_{{ $num }} check_box_q" value="{{data_get($question_info, [$num, 'score'])}}">{{ data_get($question_info, [$num, 'label']) }}</label>
                                    @endif
                                </div>
                            @endfor    
                        </div>           
    
                    </div>
                @elseif($qa->questiontype == 2 || $qa->questiontype == 5 || $qa->questiontype == 6 || $qa->questiontype == 8)
                    <div class="row main-content" id="cond_{{$qa->id}}"> 
                        <div class="col-12 form-group logic_radio">
                            @for($num= 0; $num < count($question_info) - 2; $num++)
                            <?php
                                $check_vals = json_decode($logic[$i][$j][3]);
                            ?>
                                <div class="checkbox">
                                    @if ( data_get($question_info, [$num, 'score']) == $check_vals)
                                        <label><input type="radio" name="radio_{{ $j }}_{{ $q }}" class="radio_{{ $num }} check_box_q" value="{{data_get($question_info, [$num, 'score'])}}" checked>{{ data_get($question_info, [$num, 'label']) }}</label>
                                    @else
                                        <label><input type="radio" name="radio_{{ $j }}_{{ $q }}" class="radio_{{ $num }} check_box_q" value="{{data_get($question_info, [$num, 'score'])}}">{{ data_get($question_info, [$num, 'label']) }}</label>
                                    @endif
                                </div>
                            @endfor    
                        </div> 
                    </div>
                @elseif($qa->questiontype == 3)
                    <div class="row main-content logic_img"  id="cond_{{$qa->id}}"  > 
                        <?php
                            $images = $question_info[0]->image;
                            $scores = $question_info[0]->score;
                        ?>
                        @for($num= 0; $num < count($images); $num++)
                        <?php
                            $check_vals = json_decode($logic[$i][$j][3]);
                        ?>
                            <div class="col-md-3 col-sm-6 image_box" style="padding-left:20px;width:7vw;height:10vw;" display="inline-flex" >
                                <div  class="checkbox">
                                    @if ( $check_vals[$num] > 0)
                                        <input type="checkbox" class="imagebox_{{ $num }}" checked value="{{$scores[$num]}}">
                                    @else
                                        <input type="checkbox"  class="imagebox_{{ $num }}" value="{{$scores[$num]}}">
                                    @endif
                                </div>
                                <img src="{{asset("uploads/image/".$images[$num])}}"  width="50px" height="50px" style="object-fit:fill">
                            </div>
                        @endfor
                    </div>
                @elseif($qa->questiontype == 4)
                    <div class="row main-content" id="cond_{{$qa->id}}"  >
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
                @else
                    <div class="row main-content" id="cond_{{$qa->id}}"  > 
                        <div class="col-12 form-group">
                            <div class="form-group form-md-line-input has-info">
                                <textarea class="form-control" rows="1">{{ $logic[$i][$j][3] }}</textarea>
                                <label>Please enter/select the value </label>    
                            </div>  
                        </div>                                                 
                    </div>
                @endif

            </div>
            <a class="del-condition-btn" href="javascript:del_condition({{ $i }}, {{ $j }});"><i class="fa fa-close"></i></a>
            <a class="clone-condition-btn" href="javascript:clone_condition({{ $i }}, {{ $j }});"><i class="fa fa-clone"></i></a>
        </div>
    <?php } ?>
    </div>        
    <div class="col-12">    
        <a class="btn btn-primary condition_add mt-2" href="javascript:add_condition({{ $i }});"><i class="fa fa-plus"></i> Add Conditon</a>
    </div>     
    <a class="clone-text-btn" href="javascript:clone_text({{ $i }});"><i class="fa fa-clone"></i></a>
    <a class="del-text-btn" href="javascript:del_text({{ $i }});"><i class="fa fa-close"></i></a>
    <span class="text-label">{{ ($i+1) }}</span>                   
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
    
@stop

@push('after-scripts')
    <script type="text/javascript" src="{{asset('js/textgroup-create.js')}}?t={{ time() }}"></script>
    <script>
        $(document).on('change', '#course_id', function (e) {
            var course_id = $(this).val();
            window.location.href = "?course_id=" + course_id
        });
    </script>
@endpush