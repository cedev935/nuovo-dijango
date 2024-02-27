@extends('backend.layouts.app')
@section('title', __('Charts&Tables').' | '.app_name())
<?php
$qtypes = ["Single Input", "Check Box", "RadioGroup", "Image", "Matrix", "Rating", "Dropdown", "File", "Stars", "Range", "€"];
?>
@push('before-styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.css')}}"/>   
<link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>   
@endpush
@push('after-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/charts.css')}}" />
<script type="text/javascript" src="{{asset('js/3.5.1/jquery.min.js')}}"></script>
@endpush
@section('content')
    <!-- {!! Form::open(['method' => 'POST', 'route' => ['admin.questions.store'], 'files' => true,]) !!} -->
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Charts & Tables</h3>
            <div class="float-right">
                <a href="javascript:history.back();"
                   class="btn btn-success">View Charts</a>
            </div>         
         
        </div>
        <div class="card-body">
            <div class="row">    
                <div class="col-12 form-group">
                    {!! Form::label('course_id', trans('labels.backend.tests.fields.course'), ['class' => 'control-label']) !!}
                    {!! Form::select('course_id', $courses, request('course_id', old('course_id')), ['class' => 'form-control select2']) !!}
                </div>

                <div class="col-12 form-group">
                    {!! Form::label('tests', 'Test', ['class' => 'control-label']) !!}
                 <?php 
                    $i=0;
                 ?>                 
                     <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                        @foreach($tests as $test)
                            @if ($i == 0)
                                <option value="{{$test->id}}" {{ request('test_id', $test->id) == $test->id ? 'selected' : null}}>{{ $test->title}}</option>
                                 <?php
                                    $i++;
                                ?>
                            @else
                                <option value="{{$test->id}}" {{ request('test_id', 0) == $test->id ? 'selected' : null}}>{{$test->title}}</option>                             
                            @endif 
                        @endforeach  
                    </select>

                    <div class="form-group form-md-line-input has-info" style="margin-top:10px">
                        <input type="text" class="form-control"   id="title">
                        <label for="title">Input the title</label>
                    </div>    
                  
                </div>
            </div>
        </div>
    </div>

   
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Edit</h3>           
        </div>
        <div id="question_edit" class="card-body row">
            <div class="col-4">                 
                <input type="text" data-tree="question_tree" class="btn-primary qt_name form-control" value="Questions TreeView Test">
                <div class="logic_tree question_tree" style="display:none">
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
{{--                                                    <li class="type-{{ $question_item['questiontype'] }}">{{ $question_item['id'] .'.'. strip_tags($question_item['question']) }}--}}
{{--                                                        <span >[{{ $qtypes[$question_item['questiontype']] }}]</span>{!! $score_htm.$is_condition_logic !!}</li>--}}
                                                    <li class="type-{{ $question_item['questiontype'] }}" data_value="{{strip_tags($question_item['question'])}}" onclick="updateInput(this)">{{ $question_item['id'] .'.'. strip_tags($question_item['question']) }}
                                                        <span >[{{ $qtypes[$question_item['questiontype']] }}]</span>{!! $score_htm.$is_condition_logic !!}</li>
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

                <input type="text" data-tree="textgroup_tree" class="btn-success qt_name form-control" value="Textgroups TreeView">
                <div class="logic_tree textgroup_tree" style="display:none">
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
                                            @if(isset($textgroup_list[$tk]))
                                                @for ($k=0;$k<count($textgroup_list[$tk]);$k++)
                                                    <li>
                                                        <span data-toggle="tooltip" data-placement="top" title="{{$textgroup_list[$tk][$k]['id']}}" data-testid="{{$tk}}" class= "question-item" onclick= 'selectTextGroup(event,this.getAttribute("data-testid"))'>{{ $textgroup_list[$tk][$k]['id'] }}.{{ $textgroup_list[$tk][$k]['title'] }}
                                                        </span>
                                                    </li>
                                                @endfor
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
            
            <div class="edit col-8" >               

                <div class="row main-content" id="matrix_part">                
                    <div class="col-12" id="mat_set">
                        <div class="col-12">
                            <div>
                            {!! Form::label('qt_col', trans('labels.backend.questions.fields.qt_col').'*', ['class' => 'control-label']) !!}
                            
                            </div>              
                            <div>
                                <a id="ccol_add"
                                class="btn btn-success" style="color:white; margin-top:10px;">+ Add Column</a>
                            </div>
                        </div>
                        <div id="col_panel" class="col-12" style="padding-top:10px;">
                            <div class="row" >
                                <div class="col-2">
                                    <label>Cell Type</label>  
                                </div>
                                <div class="col-2">
                                    <label>Name</label>                             
                                </div>
                            </div>
                            <div class="row" role="col">
                                <div class="col-2">
                                    <select class="form-control input-small select2me" data-placeholder="Select..."  disabled>
                                        <option >Single Input</option>
                                        <option >Checkbox</option>
                                        <option >Radiogroup</option>
                                        <option >Imagepicker</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="text" value="col1" style="z-index:20;"  class="form-control">
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="c_0">
                                        <i class="fa fa-trash" style="color:white"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- <div class="row" style="padding-top:0.5vh;">
                                <div class="col-2">
                                    <select class="form-control input-small select2me" data-placeholder="Select..."  disabled>
                                        <option >Single Input</option>
                                        <option >Checkbox</option>
                                        <option >Radiogroup</option>
                                        <option >Imagepicker</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="text" value="col2" style="z-index:20;"  class="form-control">
                                    
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                        <i class="fa fa-trash" style="color:white"></i>
                                    </a>
                                </div>
                            </div> -->
                        </div>

                        <div class="col-12">
                            <div>
                                {!! Form::label('qt_row', trans('labels.backend.questions.fields.qt_row').'*', ['class' => 'control-label']) !!}    
                            </div>              
                            <div>
                                <a id="crow_add"
                                class="btn btn-success" style="color:white; margin-top:10px;">+ Add Row</a>
                            </div>
                        </div>
                        <div id= "row_panel" class="col-12" style="padding-top:10px;">
                            <div class="row" >
                                <div class="col-2">
                                    <label>Cell Type</label>  
                                </div>
                                <div class="col-2">
                                    <label>Name</label>                             
                                </div>
                            </div>
                            <div class="row" role="row">
                                <div class="col-2">
                                    <select class="form-control input-small select2me" data-placeholder="Select..."  disabled>
                                        <option >Single Input</option>
                                        <option >Checkbox</option>
                                        <option >Radiogroup</option>
                                        <option >Imagepicker</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="text" value="row1" style="z-index:20;"  class="form-control">
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="r_0">
                                        <i class="fa fa-trash" style="color:white"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- <div class="row" style="padding-top:0.5vh;">
                                <div class="col-2"> 
                                    <select class="form-control input-small select2me" data-placeholder="Select..." disabled>
                                        <option >Single Input</option>
                                        <option >Checkbox</option>
                                        <option >Radiogroup</option>
                                        <option >Imagepicker</option>
                                    </select>   
                                </div>
                                <div class="col-2">
                                    <input type="text" value="row1" style="z-index:20;"  class="form-control">
                                    
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                        <i class="fa fa-trash" style="color:white"></i>
                                    </a>
                                </div>
                            </div> -->
                        </div>

                    </div>
                    
                    <div class="col-12" style="padding-top:3vh;">
                        {!! Form::label('value', 'value', ['class' => 'control-label']) !!}
                        <div id="htmltable" data-status="0">
                        <table id="real_matrix" width="100%">
                             <input type="hidden" placeholder="" class="form-control head" value="col2" disabled="" >
                            <tr>
                                <td><input type="text" placeholder="" class="form-control empty-cell" value="  " disabled="" ></td>
                                <td><input type="text" placeholder="" class="form-control head" value="col1" disabled="" ></td>
                            </tr>
                            <tr>
                                <td width="15%"><input type="text" placeholder="" class="form-control head" value="row1" disabled=""></td>
{{--                                <td> <input type="text" placeholder="" class="form-control formulas" id="1_1" onfocus="selectItemFunction(event)"></td>--}}
                                <td> <input type="text" placeholder="" class="clickable-input form-control formulas" id="1_1" value></td>
                            </tr>
                        </table>
                        </div>
                        <div id="htmltable1"> 
                        </div>
                    </div> 
                </div>
            </div>     
        </div>   
            
        
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Content</h3>          
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group"> 
                 
                        <div class="logic_condition row clone_condition" style="padding-top:10px;">
                            <div class="col-3" style="text-align:right">
                                <label> Type:</label>
                            </div>
                        
                            <input class="chart_type" type="hidden" value="">
                            <div class="col-5">                                    
                                <select class="form-control btn-warning" id="chart_type" placeholder="Options">
                                    <?php
                                        $types=[
                                            "pie chart",
                                            "donut chart",
                                            "bar chart",
                                            "3D bar chart",
                                            "sortable-table",
                                            "horizontal bar chart",
                                            "line chart",
                                            "radar-chart",
                                            "polar chart",
                                            "bubble chart",
                                            "responsive-table",
                                            "radar1-chart",
                                            "not chart and table",
                                            "horizontal",
                                            "stacked",
                                            "vertical",
                                            "line",
                                            "point-styling",
                                            "bubble",
                                            "combo-bar-line",
                                            "doughnut",
                                            "multi-series-pie",
                                            "pie",
                                            "polar-area",
                                            "radar",
                                            "scatter",
                                            "area-radar",
                                            "line-stacked"
                                        ];
                                    ?>
                                    @for($i=0;$i<count($types);$i++)
                                        <option value="{{ $i }}">{{ $types[$i] }}</option>
                                    @endfor               
                                </select>
                            </div>   
                            <div class="col-4">
                                    <a id="create_chart"
                                        class="btn btn-primary" style="color:white">Create Chart</a>                                                      
                                    <a id="save_new_data"
                                    class="btn btn-danger" style="color:white">Save Data</a>

                                  <!--   <a id="create_chart1"
                                        class="btn btn-primary" style="color:white">Create Chart</a>                                                      
                                    <a id="save_data"
                                    class="btn btn-danger" style="color:white">Save Data</a> -->
      
                            </div>              
                        
                        </div>
                         <div class="row" style="margin-top:10px!important">
                            <div id="table_result1" class="col-12">
                                
                            </div>
                        </div>    

                        <div class="row" style="margin-top:10px!important">
                            <div id="options-div" class="col-2">
                                <ul class="list-group">
                                    <li class="list-group-item active"><a>Chart</a></li>
                                    <li class="list-group-item"><a>Series</a></li>
                                    <li class="list-group-item"><a>Axes</a></li>
                                    <li class="list-group-item"><a>Title</a></li>
                                    <li class="list-group-item"><a>Tooltip</a></li>
                                    <li class="list-group-item"><a>Legend</a></li>
                                    <li class="list-group-item"><a>Table</a></li>
                                </ul>
                            </div>
                            <div id="option-chartdiv" class="col-2 active">
                            </div>
                            <div id="option-tablediv" class="col-2">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <label>Header FontSize:</label>
                                        <input type="number" value="16" id="th-size" class="form-control" style="width:100%;">
                                        <label>Header Color:</label>
                                        <input type="color" id="th-fcolor" value="#000000" class="form-control" style="width:100%;">
                                        <label>Header backgroundColor:</label>
                                        <input type="color" id="th-bcolor" value="#ffffff" class="form-control" style="width:100%;">
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <label>Body FontSize:</label>
                                        <input type="number" id="tb-size" value="16" class="form-control" style="width:100%;">
                                        <label>Body FontColor:</label>
                                        <input type="color" id="tb-fcolor" class="form-control" style="width:100%;">
                                        <label>Body Odd Row Color:</label>
                                        <input type="color" id="tb-ocolor" class="form-control" style="width:100%;">
                                        <label>Body Even Row Color:</label>
                                        <input type="color" id="tb-ecolor" class="form-control" style="width:100%;">
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <label>Width(%):</label>
                                        <input type="number" id="tb-width" value="100" max='100' min="0" class="form-control" style="width:100%;">
                                        <label>Height:</label>
                                        <input type="number" id="tb-height" min="0" class="form-control" style="width:100%;">
                                    </div>
                                </div>
                            </div>
                            <div id="option-seriesdiv" class="col-2">
                                <label>X-BorderColor:</label>
                                <input type="color" id="x-border-colorpicker" class="form-control" style="width:100%;">
                                <label>X-LineColor:</label>
                                <input type="color" id="x-line-colorpicker" class="form-control" style="width:100%;">
                                <label>X-TickColor:</label>
                                <input type="color" id="x-tick-colorpicker" class="form-control" style="width:100%;">
                                <label>Y-BorderColor:</label>
                                <input type="color" id="y-border-colorpicker" class="form-control" style="width:100%;">
                                <label>Y-LineColor:</label>
                                <input type="color" id="y-line-colorpicker" class="form-control" style="width:100%;">
                                <label>Y-TickColor:</label>
                                <input type="color" id="y-tick-colorpicker" class="form-control" style="width:100%;">
                            </div>
                            <div id="option-axesdiv" class="col-2">
                                <label>Width:</label>
                                <input type="number" class="form-control" id="chart-width" min="0" value="0" style="width:100%;">
                                <label>Height:</label>
                                <input type="number" class="form-control" id="chart-height" min="0" value="0" style="width:100%;">
                                <label>X-tick Size:</label>
                                <input type="number" class="form-control" id="x-size-tick" value="0" min="0" style="width:100%;">
                                <label>Y-tick Size:</label>
                                <input type="number" class="form-control" id="y-size-tick" value="0" min="0" style="width:100%;">
                                <label>Data Type:</label>
                                <select id="datatype" class="form-control">
                                    <option>-</option>
                                    <option>%</option>
                                </select>
                            </div>
                            <div id="option-titlediv" class="col-2">
                                <label>Title:</label>
                                <input type="text" class="form-control" id="title-text" style="width:100%;">
                                <label>Align:</label>
                                <select id="title-align" class="form-control">
                                    <option>start</option>
                                    <option>center</option>
                                    <option>end</option>
                                </select>
                                <label>Font Size:</label>
                                <input type="number" class="form-control" id="size-title" value="0" min="0" style="width:100%;">
                            </div>
                            <div id="option-tooltipdiv" class="col-2">
                                <label>Display:</label>
                                <select id="show-tooltip" class="form-control">
                                    <option>true</option>
                                    <option>false</option>
                                </select>
                                <label>BackgroundColor:</label>
                                <input type="color" id="tooltip-colorpicker" class="form-control" style="width:100%;">
                                <label>Border Radius:</label>
                                <input type="number" class="form-control" id="tooltip-radius" value="0" min="0" style="width:100%;">
                            </div>
                            <div id="option-legenddiv" class="col-2">
                                <label>Display:</label>
                                <select id="show-legend" class="form-control">
                                    <option>true</option>
                                    <option>false</option>
                                </select>
                                <label>Point Style:</label>
                                <select id="style-legend" class="form-control">
                                    <option>circle</option>
                                    <option>cross</option>
                                    <option>crossRot</option>
                                    <option>dash</option>
                                    <option>line</option>
                                    <option>rect</option>
                                    <option>rectRounded</option>
                                    <option>rectRot</option>
                                    <option>star</option>
                                    <option>triangle</option>
                                </select>
                                <label>Position:</label>
                                <select id="position-legend" class="form-control">
                                    <option>top</option>
                                    <option>bottom</option>
                                    <option>left</option>
                                    <option>right</option>
                                </select>
                            </div>
                        <div id="pie-chartdiv" class="col-8"></div>
                            <div id="bar-chartdiv" class="col-8"></div>
                            <div id="d3bar-chartdiv" class="col-8"></div>
                            <div id="donut-chartdiv" class="col-8"></div>
                            <div id="horizontal-chartdiv" class="col-8"></div>
                            <div id="line-chartdiv" class="col-8"></div>
                            <div id="radar-chartdiv" class="col-8"></div>
                            <div id="radar1-chartdiv" class="col-8"></div>
                            <div id="polar-chartdiv" class="col-8"></div>
                            <div id="bubble-chartdiv" class="col-8"></div>
                            <div id="no_table_chart" class="col-8"><table class="table table-striped table-bordered table-sm"></table></div>
                            <div id="responsive_table" class="col-8 custom"><table class="table table-striped table-bordered content-table table-sm"></table></div>
                            <div id="sortable_table" class="col-8 custom"><table class="table table-striped table-bordered content-table table-sm"></table></div>                            
                            <div id="table_result" class="col-8">
                            </div>
                            <div class="col-8" id="newChartArea">
                                <canvas id="myChart"></canvas>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Get the spans and attach a click event listener to each of them
                                    document.querySelectorAll('.clickable-span').forEach(function(span) {
                                        span.addEventListener('click', function() {
                                            // Set the value of the input field to the text content of the clicked span
                                            document.getElementById('selectedValue').value = span.textContent;
                                        });
                                    });
                                });
                            </script>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script type="text/javascript" src="{{asset('js/utils.js')}}"></script>
                        </div>  

                                     
                </div>
            </div>
      
       
        </div>
    </div>

    <script>
        // function updateInput(e) {
        //     var inputValue = e.getAttribute('data_value');
        //     console.log('eee=>', inputValue);
        //     document.getElementById('selectedItem').value = inputValue;
        // }

        function updateInput(clickedItem) {
            console.log('clickedItem=>', clickedItem);
            let activeInput = document.querySelector('.active-input');

            console.log('activeInput=>', activeInput);
            if (activeInput) {
                activeInput.value = clickedItem.getAttribute('data_value');
            } else {
                console.error('No active input found.');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Get the input elements and attach a click event listener to each of them
            document.querySelectorAll('.clickable-input').forEach(function(input) {
                input.addEventListener('click', function() {
                    // Remove the active-input class from all input elements
                    document.querySelectorAll('.clickable-input').forEach(function(input) {
                        input.classList.remove('active-input');
                    });
                    // Add the active-input class to the clicked input
                    input.classList.add('active-input');
                });
            });
        });
        
        // function updateClickableInput(){
        //     document.querySelectorAll('.clickable-input').forEach(function(input) {
        //         input.addEventListener('click', function() {
        //             // Remove the active-input class from all input elements
        //             document.querySelectorAll('.clickable-input').forEach(function(input) {
        //                 input.classList.remove('active-input');
        //             });
        //             // Add the active-input class to the clicked input
        //             input.classList.add('active-input');
        //         });
        //     });
        // }

    </script>

    <script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/main.js')}}?t={{time()}}"></script>

    <script type="text/javascript" src="{{asset('js/ui-nestable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.nestable.js')}}"></script>

    <!-- <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
    {{-- <script type="text/javascript" src="{{asset('js/chart-edit.js')}}"></script> --}}
    <script type="text/javascript" src="{{asset('js/chart-create.js')}}?t={{time()}}"></script>


    <script src="{{ asset('assets/metronic_assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{asset('js/3.5.1/jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    {{-- <link href="{{asset('css/custom.css')}}"  rel="stylesheet" type="text/css"/> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>   
    <script type="text/javascript" src="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>

    {{-- ///////////////////////////////chart/////////////// --}}
    <script src="{{asset('/plugins/amcharts_4/core.js')}}"></script>
    <script src="{{asset('/plugins/amcharts_4/charts.js')}}"></script>
    <script src="{{asset('/plugins/amcharts_4/themes/material.js')}}"></script>
    <script src="{{asset('/plugins/amcharts_4/themes/animated.js')}}"></script>
    <script src="{{asset('/plugins/amcharts_4/themes/kelly.js')}}"></script>
    <script src="{{asset('js/pie-chart.js')}}"></script>
    <script src="{{asset('js/bar-chart.js')}}"></script>
    <script src="{{asset('js/d3bar-chart.js')}}"></script>
    <script src="{{asset('js/donut-chart.js')}}"></script>
    <script src="{{asset('js/horizontal-bar.js')}}"></script>
    <script src="{{asset('js/line-chart.js')}}"></script>
    <script src="{{asset('js/radar-chart.js')}}"></script>
    <script src="{{asset('js/polar-chart.js')}}"></script>
    <script src="{{asset('js/bubble-chart.js')}}"></script>
    <script src="{{asset('js/radar1-chart.js')}}"></script>
    <script src="{{asset('js/responsive-table.js')}}"></script>
    <script src="{{asset('js/sortable-table.js')}}"></script>
    <script src="{{asset('js/no-table-chart.js')}}"></script>
    <script>  
          $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
       
            $('#sortable-8').sortable({
               update: function(event, ui) {
                  var productOrder = $(this).sortable('toArray').toString();
                  $("#sortable-9").text (productOrder);

                    for (var i=1;i<= $("#sortable-8").children().length ; i++)
                    {
                        $("#sortable-8 li:nth-child("+i+")").find("span.no").text( i );
                    }								
               }
            });
            $('#sortable-10').sortable({
               update: function(event, ui) {								
               }
            });
            $('#sortable-11').sortable({
               update: function(event, ui) {
               }
            });
            $('#sortable-13').sortable({
               update: function(event, ui) {
								
               }
            });
            $('#sortable-14').sortable({
               update: function(event, ui) {
               }
            });

            $(document).on('change', '#course_id', function (e) {
                var course_id = $(this).val();
                window.location.href = "?course_id=" + course_id
            });
         });
        
        jQuery(document).ready(function(e) {       
            UITree.init();  
            TableEditable.init();
            ChartCreate.init();
        })
    </script>    
@stop