<!DOCTYPE html>
@if(config('app.display_type') == 'rtl' || (session()->has('display_type') && session('display_type') == 'rtl'))
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Laravel 5 Boilerplate')">
        <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
        @if(config('favicon_image') != "")
            <link rel="shortcut icon" type="image/x-icon"
                    href="{{asset('storage/logos/'.config('favicon_image'))}}"/>
        @endif
        @yield('meta')
        
        @stack('before-styles')
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/font-awesome5.7.2/css/font-awesome.min.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/select2.min.css')}}"/>
        
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-datatable/datatables.min.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-toggle/css/bootstrap-toggle.min.css')}}"/>
        
        <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/icheck/skins/all.css')}}" id="style_components"/>
        <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/css/components.css')}}" id="style_components"/>

        <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/jstree/dist/themes/default/style.min.css')}}"/>

        <link rel="stylesheet" type="text/css" href="{{asset('css/table-bs.css')}}?t={{ time() }}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/backend.css')}}?t={{ time() }}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/frontend.css')}}?t={{ time() }}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/colors/color-5.css')}}?t={{ time() }}"/>
        
        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        @stack('after-styles')

        @if((config('app.display_type') == 'rtl') || (session('display_type') == 'rtl'))
            <style>
                .float-left {
                    float: right !important;
                }

                .float-right {
                    float: left !important;
                }
            </style>
        @endif
        <script>
            function templateAlert (title, content) {
                $('#templateAlert_content').children().find('.alert-title').text(title);
                $('#templateAlert_content').children().find('.alert-content').text(content);
                $('#templateAlert_content').attr('aria-hidden', false);
                $('#templateAlert_logo').trigger('click');
            }

            var siteinfo = {
                url_root:'{{ url('') }}',
            };
        </script>
    </head>

    <body class="{{ config('backend.body_classes') }}">
        
        @include('frontend.components.alert')
        @include('backend.includes.header')

        <div class="app-body">
            @include('backend.includes.sidebar')

            <main class="main">
                @include('includes.partials.logged-in-as')
                {{--{!! Breadcrumbs::render() !!}--}}

                <div class="container-fluid" style="padding-top: 30px">
                    <div class="animated fadeIn">
                        <div class="content-header">
                            @yield('page-header')
                        </div><!--content-header-->

                        @include('includes.partials.messages')
                        @yield('content')
                    </div><!--animated-->
                </div><!--container-fluid-->
            </main><!--main-->

            {{--@include('backend.includes.aside')--}}
        </div><!--app-body-->

        @include('backend.includes.footer')

        <!-- Scripts -->
        @stack('before-scripts')
        <script>
            //Route for message notification
            var messageNotificationRoute = '{{route('admin.messages.unread')}}'
            window._token = '{{ csrf_token() }}';
        </script>
        <!-- {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/backend.js')) !!} -->

        <script src="{{asset('js/manifest.js')}}"></script>
        <script src="{{asset('js/vendor.js')}}"></script>
        <script src="{{asset('js/backend.js')}}"></script>
        <script type="text/javascript" src="{{asset('plugins/jquery-datatable/datatables.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('plugins/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
        
        <script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/metronic_assets/global/plugins/jstree/dist/jstree.min.js')}}"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script type="text/javascript" src="{{asset('js/ui-tree.js')}}"></script>
        <script src="{{asset('js/main.js')}}" type="text/javascript"></script>
        @stack('after-scripts')

    </body>
</html>
