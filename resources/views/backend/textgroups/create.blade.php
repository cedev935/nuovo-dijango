@extends('backend.layouts.app')
@section('title', __('labels.backend.textgroups.title').' | '.app_name())
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/textgroup.css')}}" />
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Textgroup Create</h3>
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
                                <option value="{{$test->id}}">{{strip_tags($test->title)}}</option>                             
                                @endforeach  
                            </select> 
                        </div>
                    </div>
                    <div class="row form-group has-info">
                        {!! Form::label('title', 'Title *', ['class' => 'col-md-2 form-control-label']) !!}
                        <div class="col-md-10">
                            <input id="title" type="text" class="form-control required" value="" />
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title mb-0">Textgroup</h3>           
        </div>
        <div class="card-body row">
            <div class="col-12 text-box">
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
    <script type="text/javascript" src="{{asset('js/textgroup-create.js')}}"></script>
    <script>
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

