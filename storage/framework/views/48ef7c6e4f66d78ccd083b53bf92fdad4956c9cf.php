<!DOCTYPE html>
<?php if(config('app.display_type') == 'rtl' || (session()->has('display_type') && session('display_type') == 'rtl')): ?>
    <html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<?php else: ?>
    <html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php endif; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        
        <title><?php echo $__env->yieldContent('title', app_name()); ?></title>
        <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Laravel 5 Boilerplate'); ?>">
        <meta name="author" content="<?php echo $__env->yieldContent('meta_author', 'Anthony Rappa'); ?>">
        <?php if(config('favicon_image') != ""): ?>
            <link rel="shortcut icon" type="image/x-icon"
                    href="<?php echo e(asset('storage/logos/'.config('favicon_image'))); ?>"/>
        <?php endif; ?>
        <?php echo $__env->yieldContent('meta'); ?>
        
        <?php echo $__env->yieldPushContent('before-styles'); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/font-awesome5.7.2/css/font-awesome.min.css')); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/select2.min.css')); ?>"/>
        
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/jquery-datatable/datatables.min.css')); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-toggle/css/bootstrap-toggle.min.css')); ?>"/>
        
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/metronic_assets/global/plugins/icheck/skins/all.css')); ?>" id="style_components"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/metronic_assets/global/css/components.css')); ?>" id="style_components"/>

        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/metronic_assets/global/plugins/jstree/dist/themes/default/style.min.css')); ?>"/>

        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/table-bs.css')); ?>?t=<?php echo e(time()); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/backend.css')); ?>?t=<?php echo e(time()); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/frontend.css')); ?>?t=<?php echo e(time()); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/colors/color-5.css')); ?>?t=<?php echo e(time()); ?>"/>
        
        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        <?php echo $__env->yieldPushContent('after-styles'); ?>

        <?php if((config('app.display_type') == 'rtl') || (session('display_type') == 'rtl')): ?>
            <style>
                .float-left {
                    float: right !important;
                }

                .float-right {
                    float: left !important;
                }
            </style>
        <?php endif; ?>
        <script>
            function templateAlert (title, content) {
                $('#templateAlert_content').children().find('.alert-title').text(title);
                $('#templateAlert_content').children().find('.alert-content').text(content);
                $('#templateAlert_content').attr('aria-hidden', false);
                $('#templateAlert_logo').trigger('click');
            }

            var siteinfo = {
                url_root:'<?php echo e(url('')); ?>',
            };
        </script>
    </head>

    <body class="<?php echo e(config('backend.body_classes')); ?>">
        
        <?php echo $__env->make('frontend.components.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('backend.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="app-body">
            <?php echo $__env->make('backend.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <main class="main">
                <?php echo $__env->make('includes.partials.logged-in-as', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                

                <div class="container-fluid" style="padding-top: 30px">
                    <div class="animated fadeIn">
                        <div class="content-header">
                            <?php echo $__env->yieldContent('page-header'); ?>
                        </div><!--content-header-->

                        <?php echo $__env->make('includes.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    </div><!--animated-->
                </div><!--container-fluid-->
            </main><!--main-->

            
        </div><!--app-body-->

        <?php echo $__env->make('backend.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Scripts -->
        <?php echo $__env->yieldPushContent('before-scripts'); ?>
        <script>
            //Route for message notification
            var messageNotificationRoute = '<?php echo e(route('admin.messages.unread')); ?>'
            window._token = '<?php echo e(csrf_token()); ?>';
        </script>
        <!-- <?php echo script(mix('js/manifest.js')); ?>

        <?php echo script(mix('js/vendor.js')); ?>

        <?php echo script(mix('js/backend.js')); ?> -->

        <script src="<?php echo e(asset('js/manifest.js')); ?>"></script>
        <script src="<?php echo e(asset('js/vendor.js')); ?>"></script>
        <script src="<?php echo e(asset('js/backend.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/jquery-datatable/datatables.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-toggle/js/bootstrap-toggle.min.js')); ?>"></script>
        
        <script type="text/javascript" src="<?php echo e(asset('js/select2.full.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/table-editable.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('assets/metronic_assets/global/plugins/jstree/dist/jstree.min.js')); ?>"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script type="text/javascript" src="<?php echo e(asset('js/ui-tree.js')); ?>"></script>
        <script src="<?php echo e(asset('js/main.js')); ?>" type="text/javascript"></script>
        <?php echo $__env->yieldPushContent('after-scripts'); ?>

    </body>
</html>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/layouts/app.blade.php ENDPATH**/ ?>