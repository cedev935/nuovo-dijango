@extends('backend.layouts.app')
@section('title', __('Test Report(Edit)').' | '.app_name())
@push('before-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.css')}}"/>   
    <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>   
@endpush
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/testreport.css')}}" />
    <script type="text/javascript" src="{{asset('js/3.5.1/jquery.min.js')}}"></script>
    {{-- <script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> --}}
    <script src="{{asset('plugins/ckeditor4/ckeditor.js')}}"></script>
    {{-- <script type="text/javascript" src="{{asset('assets/metronic_assets/global/plugins/ckeditor/ckeditor.js')}}"></script> --}}
@endpush
@section('content')

     {{--  <form method="post" action="{{route('ckeditor.store')}}" enctype="multipart/form-data">
                        @csrf  --}}
    {!! Form::hidden('model_id',0,['id'=>'lesson_id']) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Creation Of Test Reports</h3>
            <div class="float-right">
                <a href="javascript:history.back()"
                   class="btn btn-success">@lang('labels.backend.lessons.view')</a>
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
               
                    <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                        @foreach($tests as $test)
                            <option value="{{$test->id}}">{{$test->title}}</option>                             
                        @endforeach  
                    </select> 

                    <div class="form-group form-md-line-input has-info" style="margin-top:20px;">
                        <input  id="title" type="text"  class="form-control" value="">
                        <label  class="control-label" >Input the title of Test Report</label>
                    </div>
                 
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group" id="editor">
                    <textarea class="form-control" id="content-ckeditor" name="summary"></textarea>
                </div>
            </div>

            <div class="row">

                <div class="col-12 col-lg-3 form-group">
                    <div class="checkbox">
                        <label for="published" class="checkbox control-label font-weight-bold"><input name="published" type="checkbox" value="1">Published</label>                        
                    </div>
                </div>
                <div class="col-12  text-left form-group">
                    {{--  {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn  btn-danger']) !!}  --}}
                    <button class="btn btn-danger" id="save_data">Save</button>
                </div>
            </div>
        </div>
    </div>

   {{--  </form>  --}}

  
   <div class="modal fade" id="textGroup_sc_modal" tabindex="-1" role="dialog" aria-labelledby="textGroup_sc_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="textGroup_sc_modalLabel">Insert TextGroup Short Code</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            {!! Form::label('modal_tests_id', 'Test', ['class' => 'control-label']) !!}
            <?php 
                $i=0;
            ?>                 
            <select class="form-control select2 required" name="modal_tests_id" id="modal_tests_id" placeholder="Options" multiple>
               <?php
                    $test_flag=array(); $t =0;  $tp=0;
                ?>
                @foreach($tests as $test)
                    <?php
                            $test_flag[$tp] = 0;                   
                    ?>
                     @foreach($current_tests as $current_test)                                
                        @if ($test->id == $current_test->test_id)
                            <?php     
                                $test_flag[$tp] = 1;             
                            ?>                                   
                        @endif
                    @endforeach
                    <?php
                        $tp ++; 
                    ?>
                @endforeach 

                @foreach($tests as $test)
                        @if ($test_flag[$t] == 1)
                            <option value="{{$test->id}}">{{ $test->title}}</option>
                        @else
                            <option value="{{$test->id}}" >{{ $test->title}}</option>
                        @endif
                        <?php
                            $t ++; 
                        ?>
                @endforeach 
            </select>
          </div>
          <div class="col-12">
            <table id="myTable1" style="width:100%" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('labels.general.id')</th>
                    <th>Title</th>
                    <th>Short Code</th>
                    <th>@lang('strings.backend.general.actions')</th>
                </tr>
                </thead>

                <tbody id="sortable-20">

                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="chart_sc_modal" tabindex="-1" role="dialog" aria-labelledby="chart_sc_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="chart_sc_modalLabel">Insert chart Short Code</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            {!! Form::label('modal_tests_id', 'Test', ['class' => 'control-label']) !!}
            <?php 
                $i=0;
            ?>                 
            <select class="form-control select2 required" name="modal_tests_id" id="modal_tests_id" placeholder="Options" multiple>
               <?php
                    $test_flag=array(); $t =0;  $tp=0;
                ?>
                @foreach($tests as $test)
                            <?php
                                 $test_flag[$tp] = 0;                   
                            ?>
                     @foreach($current_tests as $current_test)                                
                        @if ($test->id == $current_test->test_id)
                            <?php     
                                $test_flag[$tp] = 1;             
                            ?>                                   
                        @endif
                    @endforeach
                        <?php
                            $tp ++; 
                        ?>
                @endforeach 

                @foreach($tests as $test)
                        @if ($test_flag[$t] == 1)
                            <option value="{{$test->id}}">{{ $test->title}}</option>
                        @else
                            <option value="{{$test->id}}" >{{ $test->title}}</option>
                        @endif
                        <?php
                            $t ++; 
                        ?>
                @endforeach 
            </select>
          </div>
          <div class="col-12">
            <table id="myTable2" style="width:100%" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('labels.general.id')</th>
                    <th>Title</th>
                    <th>Short Code</th>
                    <th>@lang('strings.backend.general.actions')</th>
                </tr>
                </thead>

                <tbody id="sortable-20">

                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  @stop

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
    
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


    <script src="{{ asset('js/report-create.js') }}"></script>

    <script>
        // CKEDITOR.plugins.addExternal( 'bootstraptable', '//localhost:8000/vendor/unisharp/laravel-ckeditor/plugins/table/dialogs/', 'table.js' );
        CKEDITOR.plugins.addExternal( 'shortcode', 'plugins/shortcode/');
        CKEDITOR.replace( 'content-ckeditor', {
            height : 300,
            filebrowserUploadUrl: `{{route('admin.ckeditor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            toolbarGroups : [
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                // { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
                { name: 'links' },
                { name: 'insert' },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'shortcode',   groups: [ 'shortcode' ] },
                '/',
                // { name: 'forms' },
                // { name: 'tools' },
                // { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
                // { name: 'others' },
                { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                { name: 'styles' },
                { name: 'colors' },
                { name: 'about' },
            ],
            removeButtons : 'Underline,Subscript,Superscript',
            extraPlugins: 'font, widget, colorbutton, colordialog, justify, shortcode',
        });
jQuery(document).ready(function (e) {
    var route = "{{route('admin.textgroups.get_data_editor')}}";

    @if(request('test_id') != "")
        route = '{{route('admin.textgroups.get_data_editor',['test_id' => request('test_id')])}}';
    @else
        @if(request('course_id') != "")
            route = '{{route('admin.textgroups.get_data_editor',['course_id' => request('course_id')])}}';
        @endif
    @endif

    var route2 = "{{route('admin.charts.get_data_editor')}}";

    @if(request('test_id') != "")
        route2 = '{{route('admin.charts.get_data_editor',['test_id' => request('test_id')])}}';
    @else
        @if(request('course_id') != "")
            route2 = '{{route('admin.charts.get_data_editor',['course_id' => request('course_id')])}}';
        @endif
    @endif

    

    $('#myTable1').DataTable({
        processing: true,
        serverSide: true,
        iDisplayLength: 10,
        retrieve: true,
        ajax: route,
        buttons:[],
        columns: [
            {data: "id", name: 'id'},  
            {data: "title", name: 'title'},  
            {data: "short_code", name: 'short_code', searchable: false, orderable: false},                
            {data: "actions", name: "actions", searchable: false, orderable: false},
        ],
        language:{
            url : '{{asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')}}'
        }
    });

    $('#myTable2').DataTable({
        processing: true,
        serverSide: true,
        iDisplayLength: 10,
        retrieve: true,
        ajax: route2,
        buttons:[],
        columns: [
            {data: "id", name: 'id'},  
            {data: "title", name: 'title'},  
            {data: "short_code", name: 'short_code', searchable: false, orderable: false},                
            {data: "actions", name: "actions", searchable: false, orderable: false},
        ],
        language:{
            url : '{{asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')}}'
        }
    });

    $(document).on('change', '#modal_test_id', function (e) {
        var course_id = $('#course_id').val();
        var test_id = $(this).val();
        window.location.href = "{{route('admin.textgroups.index')}}" + "?course_id=" + course_id + "&test_id=" + test_id;
    });

});

    jQuery(document).ready(function(e) {   
        let testId = {{ request('test_id') ?? '0' }};
        if(testId) $('#tests_id').val(testId).trigger('change');
    });

    $(document).on('change', '#course_id', function (e) {
        var course_id = $(this).val();
        window.location.href = "?course_id=" + course_id
    });
</script>

@endpush

