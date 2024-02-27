@extends('backend.layouts.app')
@section('title', __('Charts&Tables(Edit)').' | '.app_name())
<?php
        $qtypes = ["Single Input", "Check Box", "RadioGroup", "Image", "Matrix", "Rating", "Dropdown", "File", "Stars", "Range", "€"];
?>
@push('before-styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.css')}}"/>
@endpush
@push('after-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/charts.css')}}" />
@endpush
@section('content')
    <!-- {!! Form::open(['method' => 'POST', 'route' => ['admin.questions.store'], 'files' => true,]) !!} -->
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Charts & Tables</h3>
            <div class="float-right">
                <a href="{{ route('admin.charts.index') }}"
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
                        $chart = json_decode(json_encode($chart)); //add ckd comment
                        $current_chart = $chart[0];
                        $current_content = json_decode($current_chart->content);
                    ?>
                    <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                        @foreach($tests as $test)
                            @foreach($current_tests as $ctest)
                                @if ($ctest->test_id == $test->id)
                                    <option value="{{$test->id}}" selected>{{$test->title}}</option>
                                @else
                                    <option value="{{$test->id}}">{{$test->title}}</option>
                                @endif
                            @endforeach
                            {{-- $current_chart->title  --}}
                        @endforeach
                    </select>
                    <div class="form-group form-md-line-input has-info" style="margin-top:10px">
                        <input type="text" class="form-control"   id="title" value="{{ $current_chart->title}}">
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
                                                    <li class="type-{{ $question_item['questiontype'] }}" data-testid="{{$tk}}" data-value="{{strip_tags($question_item['question'])}}" onclick='selectMatrixQuestion(event,this.getAttribute("data-value"))'>{{ $question_item['id'] .'.'. strip_tags($question_item['question']) }}
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
                <input type="text" data-tree="textgroup_tree" class="btn-success qt_name textgroup_name form-control" value="Textgroups TreeView">
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
                                <a id="col_add"
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
                            @for($k=1;$k< count($current_content[0]);$k++)
                                <div class="row" >
                                    <div class="col-2">
                                        <select class="form-control input-small select2me" data-placeholder="Select..."  disabled>
                                            <option >Single Input</option>
                                            <option >Checkbox</option>
                                            <option >Radiogroup</option>
                                            <option >Imagepicker</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <input type="text"  style="z-index:20;"  class="form-control" value="{{ $current_content[0][$k] }}">
                                        
                                    </div>
                                    <div class="col-2">
                                        <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                            <i class="fa fa-trash" style="color:white"></i>
                                        </a>
                                    </div>
                                </div>
                            @endfor
                            
                        </div>

                        <div class="col-12">
                            <div>
                                {!! Form::label('qt_row', trans('labels.backend.questions.fields.qt_row').'*', ['class' => 'control-label']) !!}    
                            </div>              
                            <div>
                                <a id="row_add"
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

                            @for($i =1;$i<count($current_content);$i++)
                                 <div class="row" >
                                    <div class="col-2">
                                        <select class="form-control input-small select2me" data-placeholder="Select..."  disabled>
                                            <option >Single Input</option>
                                            <option >Checkbox</option>
                                            <option >Radiogroup</option>
                                            <option >Imagepicker</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <input type="text"  style="z-index:20;"  class="form-control" value="{{ $current_content[$i][0] }}">
                                        
                                    </div>
                                    <div class="col-2">
                                        <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                            <i class="fa fa-trash" style="color:white"></i>
                                        </a>
                                    </div>
                                </div>
                            @endfor 

                        </div>

                    </div>
                    
                    <div class="col-12" style="padding-top:3vh;">
                        {!! Form::label('value', 'value', ['class' => 'control-label']) !!}

                        <table id="real_matrix" width="100%">
                            <tr>
                                <td><input type="text" placeholder="" class="form-control empty-cell" value="  " disabled="" ></td>
                                @for ($j=1;$j<count($current_content[0]);$j++)
                                    <td><input type="text" placeholder="" class="form-control head" value="{{ $current_content[0][$j] }}" disabled="" ></td>
                                @endfor
                            </tr>
                            @for($i=1;$i<count($current_content);$i++)                                
                            <tr>
                                <td width="15%"><input type="text" placeholder="" class="form-control head" value="{{ $current_content[$i][0] }}" disabled=""></td>                               
                                @for($j=1;$j<count($current_content[0]);$j++)
                                    <?php
                                        $idx = $j."_".$i;
                                    ?>
                                    <td><input type="text" placeholder="" class="form-control" value="{{ $current_content[$i][$j] }}" id="{{$idx}}" onfocus="selectItemFunction(event)"></td>
                                @endfor
                            </tr>
                            @endfor
                        </table>
                        
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
                            <input id="chart_id" type="hidden" value="{{ $current_chart->id }}">
                            <div class="col-5">                                    
                                <select class="form-control btn-warning" id="edit_chart_type" placeholder="Options">
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
                                        @if ($current_chart->type == $i)
                                            <option value="{{ $i }}" selected>{{ $types[$i] }}</option>
                                        @else
                                            <option value="{{ $i }}">{{ $types[$i] }}</option>
                                        @endif
                                    @endfor                                       
                                </select>
                            </div>   
                            <div class="col-4">
                                    <a id="create_chart"
                                        class="btn btn-primary" style="color:white">Create Chart</a>                                                      
                                    <a id="save_data"
                                        class="btn btn-danger" style="color:white">Update Data</a>
                                    <a id="save_options"
                                        class="btn btn-success" style="color:white">Save Options</a>
      
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
                            <div id="option-chartdiv" class="col-2 active" style="display: none">
                            </div>
                            <div id="option-tablediv" class="col-2" style="display: none">
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
                                        <input type="color" id="tb-fcolor" value="#000000" class="form-control" style="width:100%;">
                                        <label>Body Odd Row Color:</label>
                                        <input type="color" id="tb-ocolor" value="#ffffff" class="form-control" style="width:100%;">
                                        <label>Body Even Row Color:</label>
                                        <input type="color" id="tb-ecolor" value="#ffffff" class="form-control" style="width:100%;">
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <label>Width:</label>
                                        <input type="number" id="tb-width" value="600" min="0" class="form-control" style="width:100%;">
                                        <label>Height:</label>
                                        <input type="number" id="tb-height" value ="100" min="0" class="form-control" style="width:100%;">
                                    </div>
                                </div>
                            </div>
                            <div id="option-seriesdiv" class="col-2" style="display: none">
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
                            <div id="option-axesdiv" class="col-2" style="display: none">
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
                            <div id="option-titlediv" class="col-2" style="display: none">
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
                            <div id="option-legenddiv" class="col-2" style="display: none">
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
                            <div id="no_table_chart" class="col-8"></div>
                            <div id="responsive_table" class="col-8 custom"></div>
                            <div id="sortable_table" class="col-8 custom">
                                <table class="table table-striped table-bordered table-sm content-table" cellspacing="0" width="100%"></table>
                            </div>                            
                            <div id="table_result" class="col-8">
                            </div>
                            <div class="col-8" id="newChartArea">
                                <canvas id="myChart"></canvas>
                            </div>
                            
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script type="text/javascript" src="{{asset('js/utils.js')}}"></script>
                        </div>                  
                </div>
            </div>
      
       
        </div>
    </div>
    @stop

    @push('after-scripts')
    <script type="text/javascript" src="{{asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('js/ui-nestable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.nestable.js')}}"></script>

    {{-- <!-- <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script> --> --}}
    <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
    
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
    <script type="text/javascript" src="{{asset('js/chart-edit.js')}}?t={{time()}}"></script>
    <script>
    function updateInput(e) {
            var inputValue = e.getAttribute('data_value');
            console.log('eee=>', inputValue);
            document.getElementById('selectedItem').value = inputValue;
        }
        jQuery(document).ready(function(e) {       
            TableEditable.init();
            UITree.init(); 
            ChartEdit.init();  
            //UIToastr.init();  
        });

        $(document).on('change', '#course_id', function (e) {
            var course_id = $(this).val();
            window.location.href = "?course_id=" + course_id
        });
    </script>
    @endpush