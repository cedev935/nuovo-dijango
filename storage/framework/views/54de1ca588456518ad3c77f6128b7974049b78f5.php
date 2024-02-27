<?php $__env->startSection('title', __('labels.backend.courses.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>
    <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

    <?php echo Form::open(['method' => 'POST', 'route' => ['admin.courses.store'], 'files' => true]); ?>


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left"><?php echo app('translator')->get('labels.backend.courses.create'); ?></h3>
            <div class="float-right">
                <a href="<?php echo e(route('admin.courses.index')); ?>"
                   class="btn btn-success"><?php echo app('translator')->get('labels.backend.courses.view'); ?></a>
            </div>
        </div>

        <div class="card-body">
            <?php if(Auth::user()->isAdmin()): ?>
                <div class="row">
                    <div class="col-10 form-group">
                        <?php echo Form::label('teachers',trans('labels.backend.courses.fields.teachers'), ['class' => 'control-label']); ?>

                        <?php echo Form::select('teachers[]', $teachers, old('teachers'), ['class' => 'form-control select2 js-example-placeholder-multiple', 'multiple' => 'multiple', 'required' => true]); ?>

                    </div>
                    <div class="col-2 d-flex form-group flex-column">
                        OR <a target="_blank" class="btn btn-primary mt-auto"
                              href="<?php echo e(route('admin.teachers.create')); ?>"><?php echo e(trans('labels.backend.courses.add_teachers')); ?></a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-10 form-group">
                    <?php echo Form::label('category_id',trans('labels.backend.courses.fields.category'), ['class' => 'control-label']); ?>

                    <?php echo Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required' => true]); ?>

                </div>
                <div class="col-2 d-flex form-group flex-column">
                    OR <a target="_blank" class="btn btn-primary mt-auto"
                          href="<?php echo e(route('admin.categories.index').'?create'); ?>"><?php echo e(trans('labels.backend.courses.add_categories')); ?></a>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('title', trans('labels.backend.courses.fields.title').' *', ['class' => 'control-label']); ?>

                    <?php echo Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.title'), 'required' => false]); ?>

                </div>
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('slug',  trans('labels.backend.courses.fields.slug'), ['class' => 'control-label']); ?>

                    <?php echo Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' =>  trans('labels.backend.courses.slug_placeholder')]); ?>


                </div>
            </div>
            <div class="row">

                <div class="col-12 form-group">
                    <?php echo Form::label('description',  trans('labels.backend.courses.fields.description'), ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('description', old('description'), ['class' => 'form-control ckeditor', 'placeholder' => trans('labels.backend.courses.fields.description'),'id' => 'editor']); ?>


                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 form-group">
                    <?php echo Form::label('price',  trans('labels.backend.courses.fields.price').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']); ?>

                    <?php echo Form::number('price', old('price'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.price'),'step' => 'any', 'pattern' => "[0-9]"]); ?>

                </div>
                <div class="col-12 col-lg-4 form-group">
                    <?php echo Form::label('strike',  trans('labels.backend.courses.fields.strike').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']); ?>

                    <?php echo Form::number('strike', old('strike'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.strike'),'step' => 'any', 'pattern' => "[0-9]"]); ?>

                </div>
                <div class="col-12 col-lg-4 form-group">
                    <?php echo Form::label('course_image',  trans('labels.backend.courses.fields.course_image'), ['class' => 'control-label']); ?>

                    <?php echo Form::file('course_image',  ['class' => 'form-control', 'accept' => 'image/jpeg,image/gif,image/png']); ?>

                    <?php echo Form::hidden('course_image_max_size', 8); ?>

                    <?php echo Form::hidden('course_image_max_width', 4000); ?>

                    <?php echo Form::hidden('course_image_max_height', 4000); ?>


                </div>
                <div class="col-12 col-lg-4  form-group">
                    <?php echo Form::label('start_date', trans('labels.backend.courses.fields.start_date').' (yyyy-mm-dd)', ['class' => 'control-label']); ?>

                    <?php echo Form::text('start_date', old('start_date'), ['class' => 'form-control date','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off']); ?>


                </div>
                <?php if(Auth::user()->isAdmin()): ?>
                <div class="col-12 col-lg-4  form-group">
                    <?php echo Form::label('expire_at', trans('labels.backend.courses.fields.expire_at').' (yyyy-mm-dd)', ['class' => 'control-label']); ?>

                    <?php echo Form::text('expire_at', old('expire_at'), ['class' => 'form-control date','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.expire_at').' (Ex . 2019-01-01)', 'autocomplete' => 'off']); ?>


                </div>
                <?php endif; ?>
            </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <?php echo Form::label('add_video', trans('labels.backend.lessons.fields.add_video'), ['class' => 'control-label']); ?>


                        <?php echo Form::select('media_type', ['youtube' => 'Youtube','vimeo' => 'Vimeo','upload' => 'Upload','embed' => 'Embed'],null,['class' => 'form-control', 'placeholder' => 'Select One','id'=>'media_type' ]); ?>


                        <?php echo Form::text('video', old('video'), ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video'  ]); ?>



                        <?php echo Form::file('video_file', ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video_file'  ]); ?>


                    </div>
                    

                        

                        

                    
                    <div class="col-md-12 form-group">

                    <?php echo app('translator')->get('labels.backend.lessons.video_guide'); ?>
                    </div>

                </div>

                <div class="row">
                <div class="col-12 form-group">
                    <div class="checkbox d-inline mr-3">
                        <?php echo Form::hidden('published', 0); ?>

                        <?php echo Form::checkbox('published', 1, false, []); ?>

                        <?php echo Form::label('published',  trans('labels.backend.courses.fields.published'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>

                    <?php if(Auth::user()->isAdmin()): ?>


                    <div class="checkbox d-inline mr-3">
                        <?php echo Form::hidden('featured', 0); ?>

                        <?php echo Form::checkbox('featured', 1, false, []); ?>

                        <?php echo Form::label('featured',  trans('labels.backend.courses.fields.featured'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>

                    <div class="checkbox d-inline mr-3">
                        <?php echo Form::hidden('trending', 0); ?>

                        <?php echo Form::checkbox('trending', 1, false, []); ?>

                        <?php echo Form::label('trending',  trans('labels.backend.courses.fields.trending'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>

                    <div class="checkbox d-inline mr-3">
                        <?php echo Form::hidden('popular', 0); ?>

                        <?php echo Form::checkbox('popular', 1, false, []); ?>

                        <?php echo Form::label('popular',  trans('labels.backend.courses.fields.popular'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>

                    <?php endif; ?>

                    <div class="checkbox d-inline mr-3">
                        <?php echo Form::hidden('free', 0); ?>

                        <?php echo Form::checkbox('free', 1, false, []); ?>

                        <?php echo Form::label('free',  trans('labels.backend.courses.fields.free'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>


                </div>

            </div>

            <div class="row">
                <div class="col-12 form-group">
                    <?php echo Form::label('meta_title',trans('labels.backend.courses.fields.meta_title'), ['class' => 'control-label']); ?>

                    <?php echo Form::text('meta_title', old('meta_title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_title')]); ?>


                </div>
                <div class="col-12 form-group">
                    <?php echo Form::label('meta_description',trans('labels.backend.courses.fields.meta_description'), ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_description')]); ?>

                </div>
                <div class="col-12 form-group">
                    <?php echo Form::label('meta_keywords',trans('labels.backend.courses.fields.meta_keywords'), ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('meta_keywords', old('meta_keywords'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_keywords')]); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-12  text-center form-group">

                    <?php echo Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-danger']); ?>

                </div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script src="<?php echo e(asset('/vendor/laravel-filemanager/js/lfm.js')); ?>"></script>
    <script>
        CKEDITOR.replace('editor', {
            height : 300,
            filebrowserUploadUrl: `<?php echo e(route('admin.ckeditor_fileupload',['_token' => csrf_token() ])); ?>`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });

        $(document).ready(function () {
            $('#start_date').datepicker({
                autoclose: true,
                dateFormat: "<?php echo e(config('app.date_format_js')); ?>"
            });

            var dateToday = new Date();
            $('#expire_at').datepicker({
                autoclose: true,
                minDate: dateToday,
                dateFormat: "<?php echo e(config('app.date_format_js')); ?>"
            });

            $(".js-example-placeholder-single").select2({
                placeholder: "<?php echo e(trans('labels.backend.courses.select_category')); ?>",
            });

            $(".js-example-placeholder-multiple").select2({
                placeholder: "<?php echo e(trans('labels.backend.courses.select_teachers')); ?>",
            });
        });

        var uploadField = $('input[type="file"]');

        $(document).on('change', 'input[type="file"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if (value.size > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        })


        $(document).on('change', '#media_type', function () {
            if ($(this).val()) {
                if ($(this).val() != 'upload') {
                    $('#video').removeClass('d-none').attr('required', true)
                    $('#video_file').addClass('d-none').attr('required', false)
//                    $('#video_subtitle_box').addClass('d-none').attr('required', false)

                } else if ($(this).val() == 'upload') {
                    $('#video').addClass('d-none').attr('required', false)
                    $('#video_file').removeClass('d-none').attr('required', true)
//                    $('#video_subtitle_box').removeClass('d-none').attr('required', true)
                }
            } else {
                $('#video_file').addClass('d-none').attr('required', false)
//                $('#video_subtitle_box').addClass('d-none').attr('required', false)
                $('#video').addClass('d-none').attr('required', false)
            }
        })


    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/courses/create.blade.php ENDPATH**/ ?>