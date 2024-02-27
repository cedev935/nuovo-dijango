<?php $__env->startSection('title', __('labels.backend.tests.title').' | '.app_name()); ?>

<?php $__env->startPush('after-styles'); ?>
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

    <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

    <?php echo Form::model($test, ['method' => 'PUT', 'route' => ['admin.tests.update', $test->id]]); ?>


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0"><?php echo app('translator')->get('labels.backend.tests.edit'); ?></h3>
            <div class="float-right">
                <a href="<?php echo e(route('admin.tests.index')); ?>"
                   class="btn btn-success"><?php echo app('translator')->get('labels.backend.tests.view'); ?></a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('course_id',trans('labels.backend.tests.fields.course'), ['class' => 'control-label']); ?>

                    <?php echo Form::select('course_id', $courses, old('course_id'), ['class' => 'form-control select2']); ?>

                </div>

                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('title', trans('labels.backend.tests.fields.title'), ['class' => 'control-label']); ?>

                    <?php echo Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.tests.fields.title')]); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <?php echo Form::label('description', trans('labels.backend.tests.fields.description'), ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.tests.fields.description')]); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    <?php echo Form::label('text1', trans('labels.backend.tests.fields.text1'), ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('text1', old('text1'), ['class' => 'form-control remove-color ckeditor', 'placeholder' => '','name'=>'text1','id' => 'text1']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <?php echo Form::label('text2', trans('labels.backend.tests.fields.text2'), ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('text2', old('text2'), ['class' => 'form-control remove-color ckeditor', 'placeholder' => '','name'=>'text2','id' => 'text2']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']); ?>

                    <?php echo Form::color('color1', old('color1'), ['class' => 'form-control ']); ?>

                </div>
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']); ?>

                    <?php echo Form::color('color2', old('color2'), ['class' => 'form-control ']); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    <?php echo Form::hidden('published', 0); ?>

                    <?php echo Form::checkbox('published', 1, old('published'), []); ?>

                    <?php echo Form::label('published', trans('labels.backend.tests.fields.published'), ['class' => 'control-label font-weight-bold']); ?>


                </div>
            </div>
            
        </div>
    </div>

    <?php echo Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn  btn-danger']); ?>

    <?php echo Form::close(); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>

        CKEDITOR.replace('text1', {
            height : 150,
            filebrowserUploadUrl: `<?php echo e(route('admin.questions.editor_fileupload',['_token' => csrf_token() ])); ?>`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
            startupFocus: true,
        });

        CKEDITOR.replace('text2', {
            height : 150,
            filebrowserUploadUrl: `<?php echo e(route('admin.questions.editor_fileupload',['_token' => csrf_token() ])); ?>`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
            startupFocus: true,
        });

        /** HIDDEN TEXT AREA **/
        setTimeout(function() {
            $(CKEDITOR.instances.text1.container.$).find('.cke_contents, .cke_bottom').css('display', 'none')
            $(CKEDITOR.instances.text2.container.$).find('.cke_contents, .cke_bottom').css('display', 'none')

            CKEDITOR.instances.text2.focus();
            CKEDITOR.instances.text1.focus();

            Object.values(CKEDITOR.instances).forEach(editor => {
                var hasColor = false;

                editor.element.$.changed = (span) => {
                    editor.document.$.querySelectorAll('span').forEach(element => {
                        if(rgb2hex(element.style.color) && rgb2hex(element.style.color) !== rgb2hex(span.style.color)) {
                            element.style.color = span.style.color;
                        }
                    })
                };

                editor.document.$.querySelectorAll('span').forEach(element => {
                    if(element.style.color && !hasColor) {
                        hasColor = true;
                        return;
                    }

                    if(hasColor && element.style.color) {
                        element.remove();
                    }
                })
            });
        }, 400);

        $(".btn.btn-danger").bind("click",function(){
            var cont1=CKEDITOR.instances["text1"].editable().$.innerHTML;
            var pos1=cont1.indexOf("</span>");
            cont1=cont1.slice(0,pos1)+"&nbsp"+cont1.slice(pos1,);
            CKEDITOR.instances["text1"].setData(cont1);
            
            cont=CKEDITOR.instances["text2"].editable().$.innerHTML;
            pos=cont.indexOf("</span>");
            cont=cont.slice(0,pos)+"&nbsp"+cont.slice(pos,);
            CKEDITOR.instances["text2"].setData(cont);
        })
    </script>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/tests/edit.blade.php ENDPATH**/ ?>