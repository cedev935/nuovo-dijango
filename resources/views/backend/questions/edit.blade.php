@extends('backend.layouts.app')
@section('title', __('labels.backend.questions.title').' | '.app_name())
<?php $qtypes = ["Single Input", "Check Box", "RadioGroup", "Image", "Matrix", "Rating", "Dropdown", "File", "Stars", "Range", "€"];
$operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"]; ?>
@push('before-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.css')}}"/>   
    <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>   
@endpush
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/textgroup.css')}}" />
    <script type="text/javascript" src="{{asset('js/3.5.1/jquery.min.js')}}"></script>

    <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    {{-- <script type="text/javascript" src="{{asset('plugins/ckeditor4.23/ckeditor.js')}}"></script> --}}
@endpush
<?php 
// var_dump($questionContents); exit;
?>
@section('content')
    {{-- Test Selection --}}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Selection of Tests</h3>
            <div class="float-right">
                <a href="{{ route('admin.questions.index') }}?course_id=<?php echo isset($current_tests[0]) ? $current_tests[0]->course_id:'';?>&test_id=<?php echo isset($current_tests[0]) ? $current_tests[0]->test_id:'';?>"
                   class="btn btn-success">@lang('labels.backend.questions.view')</a>
            </div>         
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('course_id', trans('labels.backend.tests.fields.course'), ['class' => 'control-label']) !!}
                    {!! Form::select('course_id', $courses, request('course_id', old('course_id')), ['class' => 'form-control select2']) !!}
                </div>

                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('tests', 'Test', ['class' => 'control-label']) !!}
                    @php
                        $i=0;
                        $selected_tests = array();
                        foreach($question_tests as $q){
                            array_push($selected_tests, $q->test_id);
                        }
                    @endphp
                     <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                        @foreach($tests as $test)
                            <option value="{{$test->id}}" data-color1="{{$test->color1}}" data-color2="{{$test->color2}}"  @if(in_array($test->id, $selected_tests)) selected=true @endif>{{ $test->title}}</option>
                        @endforeach  
                    </select>
                    
                     <p class="help-block"></p>
                    @if($errors->has('question'))
                        <p class="help-block">
                            {{ $errors->first('question') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- End Test Selection --}}


        <div class="row">
            {{-- Question --}}
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="page-title float-left mb-0">Question Deatils</h3>           
                    </div>
                    <div id="question_edit" class="card-body">
                        <input type="hidden" id="question_id" value="{{$question->id}}">
                        <div class="row">
                            <div class="col-12" >
                                    <div class="form-group">
                                        <div class="form-group form-md-line-input has-info" style="margin-top:10px">
<!--                                            <textarea name="question_content" id="question_content" class="form-control ckeditor"></textarea>-->
                                            <!-- <input type="text" class="form-control"   id="question_content"> -->
                                            {!! Form::textarea('content', $question->question , ['class' => 'form-control ckeditor', 'placeholder' => '','name'=>'question_content','id' => 'question_content']) !!}
                                            <label for="question_content">Question</label>
                                        </div>      
                                        {{-- <div class="row">
                                            <div class="col-12 col-lg-6 form-group">
                                                {!! Form::label('f_color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']) !!}
                                                {!! Form::color('f_color1', '', ['class' => 'form-control ', 'name'=>'f_color1']) !!}
                                            </div>
                                        </div>                --}}
                                        <div class="form-group form-md-line-input has-info" style="margin-top:10px">
<!--                                            <textarea name="help-editor" id="help-editor" class="form-control ckeditor"></textarea>-->
                                            {!! Form::textarea('content', $question->help_info , ['class' => 'form-control ckeditor', 'placeholder' => '','id' => 'help-editor']) !!}
                                            <label for="question_help_info">Question Help or Information</label>
                                        </div>       
                                        <div class="row">
                                            <div class="col-12 col-lg-6 form-group">
                                                <label for="">Help information hide/show</label>
                                            <label for="hint"> <input type='radio' name='hint' class='helpaccess' value='0' @if ($question->access_help_info == 0) checked @endif   /> Hide</label>
                                            <label for="hint"><input type='radio' name='hint' class='helpaccess' value='1' @if ($question->access_help_info == 1) checked @endif /> Show</label>
                                            </div>
                                        </div>      
                                        <div class="form-group form-md-line-input has-info">
                                            {!! Form::textarea('content', $question->hint_info , ['class' => 'form-control ckeditor', 'placeholder' => '','id' => 'hint-editor']) !!}
                                            <label for="question_hint_info">Question Hint</label>
                                        </div>    
                                        <div class="row">
                                            <div class="col-12 col-lg-6 form-group">
                                                <label for="">Hint information hide/show</label>
                                            <label for="hint"> <input type='radio' name='hintRight' class='hintaccess' value='0' @if ($question->access_hint_info == 0) checked @endif   /> Hide</label>
                                            <label for="hint"><input type='radio' name='hintRight' class='hintaccess' value='1' @if ($question->access_hint_info == 1) checked @endif /> Show</label>
                                            </div>
                                        </div>            
                                        {{-- <div class="row">
                                            <div class="col-12 col-lg-6 form-group">
                                                {!! Form::label('f_color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']) !!}
                                                {!! Form::color('f_color2', '', ['class' => 'form-control ', 'name'=>'f_color2']) !!}
                                            </div>
                                        </div>    --}}
                                        @if($errors->has('question'))
                                            <p class="help-block">
                                                {{ $errors->first('question') }}
                                            </p>
                                        @endif
                                    </div>    
                                    <div class="mt-2">
                                        <div class="mb-2" style="
                                             gap: 2rem;
                                            display: flex;
                                        ">
                                            @foreach ($question->questionimage ?? [] as $image)
                                                <div id="preview" class="position-relative">
                                                    <img
                                                        width="100%"
                                                        src="{{ asset('uploads/image/'.$image)}}"
                                                    />

                                                    <input type="hidden" class="quiz_img" value="{{ $image }}" />

                                                    <button 
                                                        type="button"
                                                        style="right: 0"
                                                        class="btn remove-image btn-danger del-btn position-absolute" 
                                                    >
                                                        <i class="fa fa-trash" style="color:white"></i>
                                                    </button>
                                                </div>
                                            @endforeach

                                            <div id="preview-clone" class="hidden position-relative">
                                                <img
                                                    width="100%"
                                                    src=""
                                                />

                                                <input type="hidden" value="" />

                                                <button 
                                                    type="button"
                                                    style="right: 0"
                                                    class="btn remove-image btn-danger del-btn position-absolute" 
                                                >
                                                    <i class="fa fa-trash" style="color:white"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <form id="question_type_image" action="" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label mb-0">Image</label>
                                                <input type="file" id="img" class="form-control" name="file[]" accept="image/*">
                                                <input type="hidden" id="quiz_img" name="quiz_img">
                                            </div>
                                        </form>
                                    </div>       
                            </div>
                        </div>
                    </div>     
                </div>
                {{-- Question Type --}}
                <div class="card">
                    <div class="card-header">
                        <h3>Question Type</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            @php
                                $question_type =['Single Input','Check Box','RadioGroup','Image','Matrix','Rating','Dropdown','File','Stars','Range','€'];
                            @endphp
                            {!! Form::label('question_type', trans('labels.backend.questions.fields.question_type'), ['class' => 'control-label']) !!}
                            <select class="form-control"  name="options" id="question_type" placeholder="Options">
                                @for($i=0 ;$i< count($question_type);$i++)   
                                    <option value="{{$i}}" @if($question->questiontype==$i) selected @endif>{{ $question_type[$i]}}</option>
                                @endfor
                            </select>
                            <p class="help-block"></p>
                        </div>
                        <div id="question-type-box">
                            
                            @switch($question->questiontype)
                                {{-- Single Input --}}
                                @case(0)
                                
                                    @include('backend.questions.components.simple.single_input', [
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Checkbox --}}
                                @case(1)
                                    @include('backend.questions.components.simple.checkbox',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- RadioGroup --}}
                                @case(2)
                                    @include('backend.questions.components.simple.radiogroup',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Image --}}
                                @case(3)
                                    @include('backend.questions.components.simple.image')
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Matrix --}}
                                @case(4)
                                    @include('backend.questions.components.simple.matrix',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Rating --}}
                                @case(5)
                                {{-- Stars --}}
                                @case(8)
                                    @include('backend.questions.components.simple.rating',[
                                        'content' => $question->content,
                                        'default_color' => $question->color1 ? $question->color1 : $current_tests[0]->color1
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Dropdown --}}
                                @case(6)
                                    @include('backend.questions.components.simple.dropdown',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- File --}}
                                @case(7)
                                    @include('backend.questions.components.simple.file')
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Range --}}
                                @case(9)
                                    
                                    @include('backend.questions.components.simple.range',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Euro --}}
                                @case(10)
                                    @include('backend.questions.components.simple.euro',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @break
                                @default
                                    
                            @endswitch

                            
                            <div id="score-box" class="form-group" style="display: none;">
                                <label class="from-label">Score</label>
                                <input type="number" id="score" name="score"  class="form-control" placeholder="0" @if($question->questiontype==0) value="{{$question->score}}" @endif>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Question Type --}}
                
                {{-- Logic --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="page-title float-left mb-0">Logic</h3>          
                    </div>
                    <div class="card-body position-relative">
                        <div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i></div>
                        <div class="row">
                            <div class="col-12 form-group">                    
                                <div>
                                    <div class="logic_part" style="border:1px solid #bbbbbb;padding:10px;">
                                        <div id="sortable-14" class="condition-box">
                                            @if ($question->logic != "[]")
                                                @php
                                                    $logics = json_decode($question->logic); 
                                                @endphp
                                                @foreach($logics as $index => $logic)
                                                    <div class="row mt-3 condition" id="condition_{{$index}}">
                                                        <div class="col-sm-3">
                                                            <i style="font-size:24px" class="fa float-left fa-link pt-2 pr-2"></i>
                                                            <select style="width:auto;" class="form-control float-left btn-primary first_operator" name="first_operator" placeholder="Options">
                                                                <option value="0" {{ ($logic[0] == 0)?'selected':'' }}>And</option>
                                                                <option value="1" {{ ($logic[0] == 1)?'selected':'' }}>Or</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-7 p-0">
                                                            @php 
                                                                $questionDataInfo= DB::table('questions')->where('id','=', $logic[1])->first();
                                                                $questionContent = json_decode($questionDataInfo->content);
                                                            @endphp
                                                        <?php
                                                            $qa = $questionDataInfo;
                                                            $is_condition_logic = count(json_decode($qa->logic))>0 ? ' - <strong>condition Logic</strong>' : '';
                                                            $score_htm = '';
                                                            if ($qa->content!=null) {
                                                                $t = json_decode($qa->content);
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
                                                            <div class="qt_name form-control">
                                                                <span class="type-{{ $qa->questiontype }}"><i class="fa fa-folder"></i></span> {{ $qa->id .'. '. strip_tags($qa->question) }} - <span>[{{ $qtypes[$qa->questiontype] }}]</span>{!! $score_htm.$is_condition_logic !!}
                                                            </div>
                                                            <div class="logic_tree" style="display:none">
                                                                <ul class="treecontent">
                                                                    @for ($i=0;$i<count($course_list);$i++)
                                                                    <li>                  
                                                                    {{ $course_list[$i]['title'] }} </a>
                                                                        <ul>
                                                                            @for ($j=0;$j<count($course_test_list[$i]);$j++)
                                                                                <li>
                                                                                    {{ $course_test_list[$i][$j]['title']}}
                                                                                    <ul>
                                                                                        <?php
                                                                                            $tk=  $course_test_list[$i][$j]['id'];
                                                                                        ?>
                                                                                        @if(isset($question_list[$tk]))
                                                                                            @foreach ($question_list[$tk] as $q)
                                                                                                <?php
                                                                                                    $is_condition_logic = count(json_decode($q['logic']))>0 ? ' - <strong>condition Logic</strong>' : '';
                                                                                                    $score_htm = '';
                                                                                                    if ($q['content']!=null) {
                                                                                                        $t = json_decode($q['content']);
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
                                                                                                @if ($q['id'] == $logic[1])
                                                                                                    <li class="type-{{ $q['questiontype'] }} jstree-clicked">{{ $q['id'] .'.'. strip_tags($q['question']) }} <span>[{{ $qtypes[$q['questiontype']] }}]</span>{!! $score_htm.$is_condition_logic !!}</li>
                                                                                                @else
                                                                                                    <li class="type-{{ $q['questiontype'] }}">{{ $q['id'] .'.'. strip_tags($q['question']) }} <span>[{{ $qtypes[$q['questiontype']] }}]</span>{!! $score_htm.$is_condition_logic !!}</li>
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
                                                        @if(isset($questionDataInfo->id))
                                                            <input class="qt_type" type="hidden" value="{{$questionDataInfo->questiontype}}">
                                                        @else
                                                            <input class="qt_type" type="hidden" value="">
                                                        @endif
                                                        <div class="col-sm-2">                                    
                                                            <select class="form-control btn-warning operators" name="operators" placeholder="Options">
                                                                @for($i=0;$i<count($operators);$i++)
                                                                    <option value="{{ $i }}" {{($logic[2] == $i)?'selected':''}}>{{ $operators[$i] }}</option>
                                                                @endfor                                       
                                                            </select>
                                                        </div>
                                                        <div class="col-12 logic-content">
                                                            @if($questionDataInfo->questiontype == 1)
                                                                <div class="row  main-content" id="cond_{{$questionDataInfo->id}}"  > 
                                                                    <div class="col-12 form-group logic_check">
                                                                        @for($num= 0; $num < count($questionContent) - 2; $num++)
                                                                        <?php
                                                                            $check_vals = json_decode($logic[3]);
                                                                        ?>
                                                                            <div class="checkbox">
                                                                                @if ( $questionContent[$num]->score == $check_vals)
                                                                                    <label><input type="checkbox" class="checkbox_{{ $num }} check_box_q" value="{{$questionContent[$num]->score}}" checked>{{ $questionContent[$num]->label }}</label>
                                                                                @else
                                                                                    <label><input type="checkbox"  class="checkbox_{{ $num }} check_box_q" value="{{$questionContent[$num]->score}}">{{ $questionContent[$num]->label }}</label>
                                                                                @endif
                                                                            </div>
                                                                        @endfor    
                                                                    </div>           
                                                
                                                                </div>
                                                            @elseif($questionDataInfo->questiontype == 2 || $questionDataInfo->questiontype == 5 || $questionDataInfo->questiontype == 6 || $questionDataInfo->questiontype == 8)
                                                                <div class="row main-content" id="cond_{{$questionDataInfo->id}}"> 
                                                                    <div class="col-12 form-group logic_radio">
                                                                        @for($num= 0; $num < count($questionContent) - 2; $num++)
                                                                        <?php
                                                                            $check_vals = json_decode($logic[3]);
                                                                        ?>
                                                                            <div class="checkbox">
                                                                                @if ( $questionContent[$num]->score == $check_vals)
                                                                                    <label><input type="radio"  name="optradio{{ $questionDataInfo->id }}_{{ $i }}"  class="radio_{{ $num }}"  checked value="{{$questionContent[$num]->score}}">{{ $questionContent[$num]->label}}</label>
                                                                                @else
                                                                                    <label><input type="radio"  name="optradio{{ $questionDataInfo->id }}_{{ $i }}"  class="radio_{{ $num }}" value="{{$questionContent[$num]->score}}">{{ $questionContent[$num]->label}}</label>
                                                                                @endif
                                                                            </div>
                                                                        @endfor    
                                                                    </div> 
                                                                </div>
                                                            @elseif($questionDataInfo->questiontype == 3)
                                                                <div class="row main-content logic_img"  id="cond_{{$questionDataInfo->id}}"  > 
                                                                    <?php
                                                                        $images = $questionContent[0]->image;
                                                                        $scores = $questionContent[0]->score;
                                                                    ?>
                                                                    @for($num= 0; $num < count($images); $num++)
                                                                    <?php
                                                                        $check_vals = json_decode($logic[3]);
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
                                                            @elseif($questionDataInfo->questiontype == 4)
                                                                <div class="row main-content" id="cond_{{$questionDataInfo->id}}"  >
                                                                    <div class="col-12 form-group logic_radio">
                                                                    <?php
                                                                        $input_vals = json_decode($logic[3]);
                                                                        $inputs = explode('type="text" value="', json_decode($questionDataInfo->content));
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
                                                                <div class="row main-content" id="cond_{{$questionDataInfo->id}}"  > 
                                                                    <div class="col-12 form-group">
                                                                        <div class="form-group form-md-line-input has-info">
                                                                            <textarea class="form-control" rows="1">{{ $logic[3] }}</textarea>
                                                                            <label>Please enter/select the value </label>    
                                                                        </div>  
                                                                    </div>                                                 
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <a class="del-condition-btn" href="javascript:del_condition({{ $index }});"><i class="fa fa-close"></i></a>
                                                        <a class="clone-condition-btn" href="javascript:clone_condition({{ $index }});"><i class="fa fa-clone"></i></a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <a href="javascript:add_condition()" class="btn btn-danger"><i class="fa fa-plus"></i> Add Condition</a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                @if($errors->has('question'))
                                    <p class="help-block">
                                        {{ $errors->first('question') }}
                                    </p>
                                @endif
                        </div>
                
                    </div>
                </div>
                {{-- End Logic --}}
            </div>
            {{-- End Question --}}

            {{-- Question Properties --}}
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3>Layout Properties</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="required" id="required" placeholder="" class="form-check-input" value="1" @if($question->required==1) checked @endif/>
                                    {!! Form::label('required', 'Is Required', ['class' => 'form-check-label']) !!}
                                </div>

                                <div id="more_than_one_answer_box" class="form-check">
                                    <input type="checkbox" name="more_than_one_answer" id="more_than_one_answer" placeholder="" class="form-check-input" value="1" @if($question->more_than_one_answer==1) checked @endif />
                                    {!! Form::label('more_than_one_answer', 'More than 1 answers', ['class' => 'form-check-label']) !!}
                                </div>

                                {!! Form::label('state', 'State', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="state" placeholder="Options">
                                    @php
                                        $states = [
                                            'deafult' => 'Default',
                                            'collapased' => 'Collapsed',
                                            'expanded' => 'Expanded'
                                        ];
                                    @endphp
                                    @foreach($states as $key=>$value)
                                        <option value="{{$key}}" @if($question->state==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>

                                <h3 class="mt-2 mb-0">Description</h3>
                                <hr class="mt-0"/>

                                {!! Form::label('title_location', 'Title location', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="title_location" placeholder="Options">
                                    @php
                                        $title_location = [
                                            'default' => 'Default',
                                            'top' => 'Top',
                                            'center' => 'Center',
                                            'bottom' => 'Bottom',
                                            'left' => 'Left',
                                            'right' => 'Right',
                                            'hide' => 'Hide'
                                        ];
                                    @endphp
                                    @foreach($title_location as $key=>$value)
                                        <option value="{{$key}}" @if($question->titlelocation==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>

                                <form id="title_form" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: .5rem 1rem; padding: .5rem 0;">
                                    <div style="grid-column: span 2 / span 2;">
                                        {!! Form::label('description_align', 'Title Aligment', ['class' => 'control-label']) !!}
                                        <select class="form-control" name="layout_properties[description][align]" id="description_align" placeholder="Options">
                                            @php
                                                $title_aligment = [
                                                    'right' => 'Right',
                                                    'left' => 'Left',
                                                    'center' => 'Center',
                                                ];
                                            @endphp
                                            @foreach($title_aligment as $key=>$value)
                                                <option value="{{$key}}" @if(data_get($question->layout_properties, 'description.align')==$key) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        {!! Form::label('description_top', 'Top', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="description_top" 
                                            name="layout_properties[description][top]" 
                                            value="{{ data_get($question->layout_properties, 'description.top', 40) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('description_down', 'Down', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="description_down" 
                                            name="layout_properties[description][down]" 
                                            value="{{ data_get($question->layout_properties, 'description.down', 0) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('description_left', 'Left', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="description_left" 
                                            name="layout_properties[description][left]" 
                                            value="{{ data_get($question->layout_properties, 'description.left', 20) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('description_right', 'Right', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="description_right" 
                                            name="layout_properties[description][right]" 
                                            value="{{ data_get($question->layout_properties, 'description.right', 0) }}"
                                        />
                                    </div>
                                </form>

                                <h3 class="mt-2 mb-0">Answer</h3>
                                <hr class="mt-0"/>

                                {!! Form::label('answer_location', 'Answer location', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="answerposition" placeholder="Options">
                                    @php
                                        $answer_location = [
                                            'default' => 'Default',
                                            'top' => 'Top',
                                            'center' => 'Center',
                                            'bottom' => 'Bottom',
                                            'left' => 'Left',
                                            'right' => 'Right',
                                            'hide' => 'Hide'
                                        ];
                                    @endphp
                                    @foreach($answer_location as $key=>$value)
                                        <option value="{{$key}}" @if($question->answerposition==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>

                                {!! Form::label('answer_aligment', 'Answer Aligment', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="answer_aligment" placeholder="Options">
                                    @php
                                        $answer_aligment = [
                                            'left' => 'Left',
                                            'right' => 'Right',
                                            'center' => 'Center',
                                            'space-between' => 'Full',
                                        ];
                                    @endphp
                                    @foreach($answer_aligment as $key=>$value)
                                        <option value="{{$key}}" @if($question->answer_aligment==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>

                                <form id="answer_form" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: .5rem 1rem; padding: .5rem 0;">
                                    <div>
                                        {!! Form::label('answer_top', 'Top', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="answer_top" 
                                            name="layout_properties[answer][top]" 
                                            value="{{ data_get($question->layout_properties, 'answer.top', 20) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('answer_down', 'Down', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="answer_down" 
                                            name="layout_properties[answer][down]" 
                                            value="{{ data_get($question->layout_properties, 'answer.down', 0) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('answer_left', 'Left', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="answer_left" 
                                            name="layout_properties[answer][left]" 
                                            value="{{ data_get($question->layout_properties, 'answer.left', 20) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('answer_right', 'Right', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="answer_right" 
                                            name="layout_properties[answer][right]" 
                                            value="{{ data_get($question->layout_properties, 'answer.right', 0) }}"
                                        />
                                    </div>
                                </form>

                                <h3 class="mt-2 mb-0">Image</h3>
                                <hr class="mt-0"/>

                                {!! Form::label('image_location', 'Image location', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="imageposition" placeholder="Options">
                                    @php
                                        $image_location = [
                                            'default' => 'Default',
                                            'top' => 'Top',
                                            'center' => 'Center',
                                            'bottom' => 'Bottom',
                                            'left' => 'Left',
                                            'right' => 'Right',
                                            'hide' => 'Hide'
                                        ];
                                    @endphp
                                    @foreach($image_location as $key=>$value)
                                        <option value="{{$key}}" @if($question->imageposition==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>

                                {!! Form::label('image_aligment', 'Image Aligment', ['class' => 'control-label']) !!}
                                <select class="form-control" name="image_aligment" id="image_aligment" placeholder="Options">
                                    @php
                                        $image_aligment = [
                                            // 'full' => 'Full',
                                            'right' => 'Right',
                                            'left' => 'Left',
                                            'center' => 'Center',
                                        ];
                                    @endphp
                                    @foreach($image_aligment as $key=>$value)
                                        <option value="{{$key}}" @if($question->image_aligment==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>

                                <form id="image_form" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: .5rem 1rem; padding: .5rem 0;">
                                    <div>
                                        {!! Form::label('image_top', 'Top', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="image_top" 
                                            name="layout_properties[image][top]" 
                                            value="{{ data_get($question->layout_properties, 'image.top', 30) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('image_down', 'Down', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="image_down" 
                                            name="layout_properties[image][down]" 
                                            value="{{ data_get($question->layout_properties, 'image.down', 0) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('image_left', 'Left', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="image_left" 
                                            name="layout_properties[image][left]" 
                                            value="{{ data_get($question->layout_properties, 'image.left', 10) }}"
                                        />
                                    </div>
        
                                    <div>
                                        {!! Form::label('image_right', 'Right', ['class' => 'control-label m-0']) !!}
                                        <input 
                                            type="number" 
                                            placeholder="" 
                                            class="form-control" 
                                            id="image_right" 
                                            name="layout_properties[image][right]" 
                                            value="{{ data_get($question->layout_properties, 'image.right', 0) }}"
                                        />
                                    </div>
                                </form>

                                {!! Form::label('imagefit', 'Image Fit', ['class' => 'control-label']) !!}  
                                <select class="form-control" name="options" id="image_fit" placeholder="Options">
                                    @php
                                        $image_fit = [
                                            'none' => 'None',
                                            'contain' => 'Contain',
                                            'cover' => 'Cover',
                                            'fill' => 'Fill'
                                        ];
                                    @endphp
                                    @foreach($image_fit as $key=>$value)
                                        <option value="{{$key}}" @if($question->imagefit==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                <div id="image_fit1"></div>
                                {!! Form::label('image_width', 'Image Width', ['class' => 'control-label']) !!}
                                <input type="text" name="image_width" id="image_width" placeholder="" class="form-control"  value="{{$question->imagewidth}}"/>
                                <div id="image_width1"></div>
                                {!! Form::label('image_height', 'Image Height', ['class' => 'control-label']) !!}
                                <input type="text" name="image_height" id="image_height" placeholder="" class="form-control"  value="{{$question->imageheight}}"/>
                                <div id="image_height1"></div>

                                <h3 class="mt-2 mb-0">Question</h3>
                                <hr class="mt-0"/>

                                {!! Form::label('question_bg_color', 'Question Background', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="question_bg_color" placeholder="Options">
                                    @php
                                        $question_bg_color = [
                                            '#fff' => 'White',
                                            '#ff5733' => 'Light Brown',
                                            '#ffe933' => 'Yellow',
                                            '#cab81d' => 'Dark yellow',
                                            '#1d76ca' => 'Blue',
                                        ];
                                    @endphp
                                    @foreach($question_bg_color as $key=>$value)
                                        <option value="{{$key}}" @if($question->question_bg_color==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                <!-- {!! Form::label('help_info_location', 'Help Info location', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="help_info_location" placeholder="Options">
                                    @php
                                        $help_info_location = [
                                            'deafult' => 'Default',
                                            'top' => 'Top',
                                            'bottom' => 'Bottom',
                                            'left' => 'Left',
                                            'hidden' => 'Hidden'
                                        ];
                                    @endphp
                                    @foreach($help_info_location as $key=>$value)
                                        <option value="{{$key}}" @if($question->help_info_location==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select> -->
                                {!! Form::label('indent', 'Indent', ['class' => 'control-label']) !!}
                                <input type="number" name="indent" id="indent" placeholder="" class="form-control" value="{{$question->indent}}"/>

                                {!! Form::label('width', 'Width', ['class' => 'control-label']) !!}
                                <input type="number" name="width" id="width" placeholder="" class="form-control" value="{{$question->width}}"/>

                                {!! Form::label('min_width', 'Min Width', ['class' => 'control-label']) !!}
                                <input type="number" name="min_width" id="min_width" placeholder="" class="form-control" value="{{$question->min_width}}"/>

                                {!! Form::label('max_width', 'Max Width', ['class' => 'control-label']) !!}
                                <input type="number" name="max_width" id="max_width" placeholder="" class="form-control" value="{{$question->max_width}}"/>

                                {!! Form::label('size', 'Size', ['class' => 'control-label']) !!}
                                <input type="number" name="size" id="size" placeholder="" class="form-control"  value="{{$question->size}}"/>

                                {{--{!! Form::label('font_size', 'Font size', ['class' => 'control-label']) !!}
                                <input type="text" name="font_size" id="font_size" placeholder="" class="form-control"  value="{{ $current_question->fontsize }}"/>
                                <div id="font_size1"></div>
                                {!! Form::label('column_count', 'Column Count', ['class' => 'control-label']) !!}
                                <input type="text" name="column_count" id="column_count" placeholder="" class="form-control" /> --}}
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="mt-2 mb-2">
                    <button id="save_data" class="btn btn-danger">Save Data</button>
                </div>
            </div>
            {{-- End Question Properties --}}
        </div>


    

    <!-- @for ($question=1; $question<=2; $question++)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('option_text_' . $question, trans('labels.backend.questions.fields.option_text').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('option_text_' . $question, old('option_text'), ['class' => 'form-control ', 'rows' => 3, 'required' =>  true]) !!}
                    <p class="help-block"></p>
                    @if($errors->has('option_text_' . $question))
                        <p class="help-block">
                            {{ $errors->first('option_text_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('explanation_' . $question, trans('labels.backend.questions.fields.option_explanation'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('explanation_' . $question, old('explanation_'.$question), ['class' => 'form-control ', 'rows' => 3]) !!}
                    <p class="help-block"></p>
                    @if($errors->has('explanation_' . $question))
                        <p class="help-block">
                            {{ $errors->first('explanation_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('correct_' . $question, trans('labels.backend.questions.fields.correct'), ['class' => 'control-label']) !!}
                    {!! Form::hidden('correct_' . $question, 0) !!}
                    {!! Form::checkbox('correct_' . $question, 1, false, []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('correct_' . $question))
                        <p class="help-block">
                            {{ $errors->first('correct_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endfor
    <div class="col-12 text-center">
        {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-danger mb-4 form-group']) !!}
    </div>

    {!! Form::close() !!} -->
    
@stop
@push('after-scripts')
    <script type="text/javascript" src="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<!--
    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    -->
    <script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/jquery.nestable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/ui-nestable.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/question-create.js')}}?t={{ time() }}"></script>
    <script>
        function radioScore(ele){
            $(ele).data('value',ele.value);
            $('#'+ele.dataset.q_id).attr('value',ele.value);
        }    

        CKEDITOR.replace('question_content', {
            fontSize_defaultLabel : '34px',
            height : 300,
            filebrowserUploadUrl: `{{route('admin.questions.editor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });

        CKEDITOR.replace('help-editor', {
            height : 300,
            filebrowserUploadUrl: `{{route('admin.questions.editor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });

        CKEDITOR.replace('hint-editor', {
            height : 300,
            filebrowserUploadUrl: `{{route('admin.questions.editor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });

        /*$('.editor').each(function () {

            CKEDITOR.replace($(this).attr('id'), {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',

                //extraPlugins: 'font,smiley,lineutils,widget,codesnippet,prism,flash,colorbutton,colordialog',
                extraPlugins: 'font,widget,colorbutton,colordialog,justify',
            });

        });*/

        jQuery(document).ready(function(e) {       
            UINestable.init();
            TableEditable.init();
            QuestionCreate.init();  
            //UIToastr.init();  
            $('#tests_id').on('change', function() {
                var selectedVals = $('#tests_id').val();
                if (selectedVals.length) {
                    var selectedOption = $(`#tests_id option[value=${selectedVals[0]}]`);
                    var color1 = selectedOption.data('color1');
                    var color2 = selectedOption.data('color2');
                    $('#color1').val(color1);
                    $('#color2').val(color2);
                    $('#color').val(color1);
                }
            })
        });
        var radio_id=50;
        jQuery(document).ready(function(e) {       
            $('.logic_tree').jstree({
                "core" : {
                    "themes" : {
                        "responsive": false
                    }            
                },
                "types" : {
                    "default" : {
                        "icon" : "fa fa-folder icon-state-warning icon-lg"
                    },
                    "file" : {
                        "icon" : "fa fa-file icon-state-warning icon-lg"
                    }
                },
                "plugins": ["types"]
            });    
            $('.logic_tree').on('select_node.jstree', function(e, data) { 
                if (data.node.children.length>1) {
                    return;
                }
                e.preventDefault();
                var str = $.trim($('#' + data.selected).text());
                var logiccontent=$(this).parent().siblings(".logic-content");
                var qt_type_in= $(this).parent().siblings(".qt_type");
                var qt_nm = $(this).siblings(".qt_name");

                var name= str.split(".");
                if (name.length>1) {
                    var qt_id = name[0];
                    $.ajax({
                        data: {id: qt_id},
                        url: siteinfo.url_root + "/user/textgroups/get_info",
                        type: "GET",
                        dataType: 'json',
                        success: function (response) {
                            var type = response['data']['questiontype'];
                            var html_append = ``;
                            qt_type_in.val(type);
                            qt_nm.html(response['in_html']);
                            if (type == 1) {
                                var content = JSON.parse(response['data']['content']);
                                var img_name = response['data']['questionimage'];
                                var img_path = "";
                                if (img_name != null && img_name != "")
                                    img_path = siteinfo.url_root+"/public/uploads/image/" + img_name;
                                html_append = `<div class="row main-content" id="cond_` + response['data']['id'] + `" >
                                                <div class="col-7 form-group logic_check">`;
                                for (var i = 0; i < content.length - 2; i++) {
                                    var is_checked = "";
                                    if (content[i]['is_checked'] == 1) {
                                        is_checked = "checked";
                                    }
                                    var score = content[i]['score'];
                                    var label = content[i]['label'];
                                    html_append += `<div class="checkbox"><label>
                                                        <input class="checkbox_` + i + ` check_box_q" type="checkbox" value="` + score + `" ` + is_checked + ` >` + label + `
                                                    </label></div>`;
                                }

                                html_append += `</div>                
                                                <div class="col-4">
                                                    <div class="form-body">                                    
                                                        <div class="form-group ">`;
                                                        if (img_path!='')
                                                        html_append += `
                                                            <img class="display-image-preview" src="` + img_path + `"
                                                            style="max-height: 150px;">`;

                                html_append += `        </div>
                                                    </div>
                                                </div>                   
                                            </div>`;
                            }
                            else if (type == 2 || type == 5 || type == 6 || type == 8) {
                                var content = JSON.parse(response['data']['content']);
                                radio_id++;
                                var img_name = response['data']['questionimage'];
                                var img_path = "";
                                if (img_name != null && img_name != "")
                                    img_path = siteinfo.url_root+"/public/uploads/image/" + img_name;
                                html_append = `<div class="row main-content" id="cond_` + response['data']['id'] + `"  >       
                                        <div class="col-7 form-group logic_radio">`;
                                for (var i = 0; i < content.length - 2; i++) {
                                    var is_checked = "";
                                    if (content[i]['is_checked'] == 1) {
                                        is_checked = "checked";
                                    }
                                    var score = content[i]['score'];
                                    var label = content[i]['label'];
                                    html_append += `<div class="radio"><label>
                                                    <input class="radio_` + i + `" type="radio" name="optradio` + response['data']['id'] + `_` + radio_id + `" value="` + score + `" `+is_checked+`>` + label + `</label>                      
                                                </div>`;
                                }
                                html_append += `</div>                
                                                <div class="col-4">
                                                    <div class="form-body">                                    
                                                        <div class="form-group ">`;
                                                        if (img_path!='')
                                                        html_append += `
                                                            <img class="display-image-preview" src="` + img_path + `"
                                                            style="max-height: 150px;">`;

                                html_append += `       </div>
                                                    </div>
                                                </div>                    
                                            </div>`;
                            }

                            else if (type == 3) {
                                var content = JSON.parse(response['data']['content']);
                                html_append = `<div class="row main-content logic_img" id="cond_` + response['data']['id'] + `"  >`;
                                var images = content[0]['image'];
                                var scores = content[0]['score'];
                                for (var i = 0; i < images.length; i++) {
                                    var image = "";
                                    if (images[i] != null && images[i] != "")
                                        image = siteinfo.url_root+"/public/uploads/image/" + images[i];
                                    html_append += `<div class="col-md-3 col-sm-6 image_box" style="padding-left:20px;width:7vw;height:10vw;" display="inline-flex" >
                                                        <div class="checkbox">
                                                            <input class="imagebox_` + i + `" type="checkbox" class="img_check` + i + `" value="` + scores[i] + `">                      
                                                        </div>`;
                                    if (image!='')
                                    html_append += `<img src="` + image + `"  width="50px" height="50px" style="object-fit:fill">`;
                                    html_append += `</div>`;
                                }
                                html_append += `</div>`;
                            }

                            else if (type == 4) {
                                var img_name = response['data']['questionimage'];
                                var img_path = "";
                                if (img_name != null && img_name != "")
                                    img_path = siteinfo.url_root+"/public/uploads/image/" + img_name;
                                var content = response['data']['content'];
                                html_append = `<div class="row main-content" id="cond_` + response['data']['id'] + `"  >
                                                    <div class="col-12 form-group">` + content;
                                html_append += `</div> 
                                                <div class="col-4">
                                                    <div class="form-body">                                    
                                                        <div class="form-group ">`;
                                                        if (img_path!='')
                                                        html_append += `
                                                            <img class="display-image-preview" src="` + img_path + `"
                                                            style="max-height: 150px;">`;
                            html_append += `            </div>
                                                    </div>
                                                </div>                   
                                            </div>`;
                            }

                            else {
                                var content = JSON.parse(response['data']['content']);
                                html_append = `<div class="row main-content" id="cond_` + response['data']['id'] + `"  >
                                                <div class="col-8 form-group">
                                                    <div class="form-group form-md-line-input">
                                                        <textarea class="form-control" rows="1"></textarea>
                                                        <label for="form_control_1">Please enter/select the value</label>
                                                    </div>  
                                            
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-body">                                    
                                                        <div class="form-group ">`;
                                                    if (response['data']['questionimage']!=null && response['data']['questionimage']!='')    
                                html_append += `            <img class="display-image-preview" src="` + siteinfo.url_root+"/public/uploads/image/" + response['data']['questionimage'] + `" style="max-height: 150px;" />`;
                                html_append += `     </div>
                                        
                                                    </div>
                                                </div>
                                            </div> `;
                            }

                            logiccontent.html(html_append);
                            $('.custom-hide').remove();


                        },
                        error: function (response) {
                            console.log(response);
                        }
                    });
                }
                $(this).hide();
            });
            $(".logic_tree").hide();
            var timer = setTimeout(function () {
                $('.ajax-loading').fadeOut(300);
                clearTimeout(timer);
            }, 1000);
        });

        $(document).on('change', '#course_id', function (e) {
            var course_id = $(this).val();
            window.location.href = "?course_id=" + course_id
        });
    </script>
@endpush
