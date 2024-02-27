<?php $__env->startSection('title', __('labels.backend.courses.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>

    <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

    <?php echo Form::model($course, ['method' => 'PUT', 'route' => ['admin.courses.update', $course->id], 'files' => true,]); ?>


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0"><?php echo app('translator')->get('labels.backend.courses.edit'); ?></h3>
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

                        <?php echo Form::select('teachers[]', $teachers, old('teachers') ? old('teachers') : $course->teachers->pluck('id')->toArray(), ['class' => 'form-control select2', 'multiple' => 'multiple','required' => true]); ?>

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

                    <?php echo Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']); ?>

                </div>
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('slug', trans('labels.backend.courses.fields.slug'), ['class' => 'control-label']); ?>

                    <?php echo Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' =>  trans('labels.backend.courses.slug_placeholder')]); ?>

                </div>

            </div>

            <div class="row">
                <div class="col-12 form-group">
                    <?php echo Form::label('description',trans('labels.backend.courses.fields.description'), ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('description', old('description'), ['class' => 'form-control ckeditor', 'placeholder' => trans('labels.backend.courses.fields.description'),'id' => 'editor']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 form-group">
                    <?php echo Form::label('price', trans('labels.backend.courses.fields.price').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']); ?>

                    <?php echo Form::number('price', old('price'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.price') ,'step' => 'any', 'pattern' => "[0-9]"]); ?>

                </div>
                <div class="col-12 col-lg-4 form-group">
                    <?php echo Form::label('strike', trans('labels.backend.courses.fields.strike').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']); ?>

                    <?php echo Form::number('strike', old('strike'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.strike') ,'step' => 'any', 'pattern' => "[0-9]"]); ?>

                </div>
                <div class="col-12 col-lg-4 form-group">

                    <?php echo Form::label('course_image', trans('labels.backend.courses.fields.course_image'), ['class' => 'control-label','accept' => 'image/jpeg,image/gif,image/png']); ?>

                    <?php echo Form::file('course_image', ['class' => 'form-control']); ?>

                    <?php echo Form::hidden('course_image_max_size', 8); ?>

                    <?php echo Form::hidden('course_image_max_width', 4000); ?>

                    <?php echo Form::hidden('course_image_max_height', 4000); ?>

                    <?php if($course->course_image): ?>
                        <a href="<?php echo e(asset('storage/uploads/'.$course->course_image)); ?>" target="_blank"><img
                                    height="50px" src="<?php echo e(asset('storage/uploads/'.$course->course_image)); ?>"
                                    class="mt-1"></a>
                    <?php endif; ?>
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <?php echo Form::label('start_date', trans('labels.backend.courses.fields.start_date').' (yyyy-mm-dd)', ['class' => 'control-label']); ?>

                    <?php echo Form::text('start_date', old('start_date'), ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('start_date')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('start_date')); ?>

                        </p>
                    <?php endif; ?>
                </div>
                <?php if(Auth::user()->isAdmin()): ?>
                <div class="col-12 col-lg-4 form-group">
                    <?php echo Form::label('expire_at', trans('labels.backend.courses.fields.expire_at').' (yyyy-mm-dd)', ['class' => 'control-label']); ?>

                    <?php echo Form::text('expire_at', old('expire_at'), ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.expire_at').' (Ex . 2019-01-01)','autocomplete' => 'off']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('expire_at')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('expire_at')); ?>

                        </p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <?php echo Form::label('add_video', trans('labels.backend.lessons.fields.add_video'), ['class' => 'control-label']); ?>

                    <?php echo Form::select('media_type', ['youtube' => 'Youtube','vimeo' => 'Vimeo','upload' => 'Upload','embed' => 'Embed'],($course->mediavideo) ? $course->mediavideo->type : null,['class' => 'form-control', 'placeholder' => 'Select One','id'=>'media_type' ]); ?>



                    <?php echo Form::text('video', ($course->mediavideo) ? $course->mediavideo->url : null, ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video'  ]); ?>


                    <?php echo Form::file('video_file', ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video_file','accept' =>'video/mp4'  ]); ?>

                    <input type="hidden" name="old_video_file"
                           value="<?php echo e(($course->mediavideo && $course->mediavideo->type == 'upload') ? $course->mediavideo->url  : ""); ?>">
                    <?php if($course->mediavideo != null): ?>
                        <div class="form-group">
                            <a href="#" data-media-id="<?php echo e($course->mediaVideo->id); ?>"
                               class="btn btn-xs btn-danger my-3 delete remove-file"><?php echo app('translator')->get('labels.backend.lessons.remove'); ?></a>
                        </div>
                    <?php endif; ?>



                    <?php if($course->mediavideo && ($course->mediavideo->type == 'upload')): ?>
                        <video width="300" class="mt-2 d-none video-player" controls>
                            <source src="<?php echo e(($course->mediavideo && $course->mediavideo->type == 'upload') ? $course->mediavideo->url  : ""); ?>"
                                    type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>

                    <?php endif; ?>

                    <?php echo app('translator')->get('labels.backend.lessons.video_guide'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    <div class="checkbox d-inline mr-4">
                        <?php echo Form::hidden('published', 0); ?>

                        <?php echo Form::checkbox('published', 1, old('published'), []); ?>

                        <?php echo Form::label('published', trans('labels.backend.courses.fields.published'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>

                    <?php if(Auth::user()->isAdmin()): ?>

                    <div class="checkbox d-inline mr-4">
                        <?php echo Form::hidden('featured', 0); ?>

                        <?php echo Form::checkbox('featured', 1, old('featured'), []); ?>

                        <?php echo Form::label('featured',  trans('labels.backend.courses.fields.featured'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>

                    <div class="checkbox d-inline mr-4">
                        <?php echo Form::hidden('trending', 0); ?>

                        <?php echo Form::checkbox('trending', 1, old('trending'), []); ?>

                        <?php echo Form::label('trending',  trans('labels.backend.courses.fields.trending'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>

                    <div class="checkbox d-inline mr-4">
                        <?php echo Form::hidden('popular', 0); ?>

                        <?php echo Form::checkbox('popular', 1, old('popular'), []); ?>

                        <?php echo Form::label('popular',  trans('labels.backend.courses.fields.popular'), ['class' => 'checkbox control-label font-weight-bold']); ?>

                    </div>
                    <?php endif; ?>
                    <div class="checkbox d-inline mr-4">
                        <?php echo Form::hidden('free', 0); ?>

                        <?php echo Form::checkbox('free', 1, old('free'), []); ?>

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
                    <?php echo Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn btn-danger']); ?>

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
        $(document).on('change', 'input[type="file"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if (value.size > 50000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        });

        $(document).ready(function () {
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                var parent = $(this).parent('.form-group');
                var confirmation = confirm('<?php echo e(trans('strings.backend.general.are_you_sure')); ?>')
                if (confirmation) {
                    var media_id = $(this).data('media-id');
                    $.post('<?php echo e(route('admin.media.destroy')); ?>', {media_id: media_id, _token: '<?php echo e(csrf_token()); ?>'},
                        function (data, status) {
                            if (data.success) {
                                parent.remove();
                                $('#video').val('').addClass('d-none').attr('required', false);
                                $('#video_file').attr('required', false);
                                $('#media_type').val('');
                                <?php if($course->mediavideo && $course->mediavideo->type ==  'upload'): ?>
                                $('.video-player').addClass('d-none');
                                $('.video-player').empty();
                                <?php endif; ?>


                            } else {
                                alert('Something Went Wrong')
                            }
                        });
                }
            })
        });


        <?php if($course->mediavideo): ?>
        <?php if($course->mediavideo->type !=  'upload'): ?>
        $('#video').removeClass('d-none').attr('required', true);
        $('#video_file').addClass('d-none').attr('required', false);
        $('.video-player').addClass('d-none');
        <?php elseif($course->mediavideo->type == 'upload'): ?>
        $('#video').addClass('d-none').attr('required', false);
        $('#video_file').removeClass('d-none').attr('required', false);
        $('.video-player').removeClass('d-none');
        <?php else: ?>
        $('.video-player').addClass('d-none');
        $('#video_file').addClass('d-none').attr('required', false);
        $('#video').addClass('d-none').attr('required', false);
        <?php endif; ?>
        <?php endif; ?>

        $(document).on('change', '#media_type', function () {
            if ($(this).val()) {
                if ($(this).val() != 'upload') {
                    $('#video').removeClass('d-none').attr('required', true);
                    $('#video_file').addClass('d-none').attr('required', false);
                    $('.video-player').addClass('d-none')
                } else if ($(this).val() == 'upload') {
                    $('#video').addClass('d-none').attr('required', false);
                    $('#video_file').removeClass('d-none').attr('required', true);
                    $('.video-player').removeClass('d-none')
                }
            } else {
                $('#video_file').addClass('d-none').attr('required', false);
                $('#video').addClass('d-none').attr('required', false)
            }
        })


    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/courses/edit.blade.php ENDPATH**/ ?>