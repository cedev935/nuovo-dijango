<?php $__env->startSection('title', __('labels.backend.hero_slider.title').' | '.app_name()); ?>

<?php $__env->startPush('after-styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/amigo-sorter/css/theme-default.css')); ?>">
    <style>
        ul.sorter > span {
            display: inline-block;
            width: 100%;
            height: 100%;
            background: #f5f5f5;
            color: #333333;
            border: 1px solid #cccccc;
            border-radius: 6px;
            padding: 0px;
        }

        ul.sorter li > span .title {
            padding-left: 15px;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }


    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline"><?php echo app('translator')->get('labels.backend.hero_slider.title'); ?></h3>
            <div class="float-right">
                <a href="<?php echo e(route('admin.sliders.create')); ?>"
                   class="btn btn-success"><?php echo app('translator')->get('strings.backend.general.app_add_new'); ?></a>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                                <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.hero_slider.fields.name'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.hero_slider.fields.bg_image'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.hero_slider.fields.sequence'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.hero_slider.fields.status'); ?></th>
                                <?php if( request('show_deleted') == 1 ): ?>
                                    <th>&nbsp; <?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                                <?php else: ?>
                                    <th>&nbsp; <?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $slides_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $key++ ?>
                                <tr>
                                    <td>
                                        <?php echo e($key); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->id); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->name); ?>

                                    </td>
                                    <td>
                                        <img src="<?php echo e(asset('storage/uploads/'.$item->bg_image)); ?>" height="50px">
                                    </td>
                                    <td>
                                        <?php echo e($item->sequence); ?>

                                    </td>
                                    <td>
                                        <?php echo e(html()->label(html()->checkbox('')->id($item->id)
                ->checked(($item->status == 1) ? true : false)->class('switch-input')->attribute('data-id', $item->id)->value(($item->status == 1) ? 1 : 0).'<span class="switch-label"></span><span class="switch-handle"></span>')->class('switch switch-lg switch-3d switch-primary')); ?>

                                        
                                    </td>
                                    <td>


                                        <a href="<?php echo e(route('admin.sliders.edit',['slider'=>$item->id])); ?>"
                                           class="btn btn-xs btn-info mb-1"><i class="icon-pencil"></i></a>

                                        <a data-method="delete" data-trans-button-cancel="Cancel"
                                           data-trans-button-confirm="Delete" data-trans-title="Are you sure?"
                                           class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;"
                                           onclick="$(this).find('form').submit();">
                                            <i class="fa fa-trash"
                                               data-toggle="tooltip"
                                               data-placement="top" title=""
                                               data-original-title="Delete"></i>
                                            <form action="<?php echo e(route('admin.sliders.destroy',['slider'=>$item->id])); ?>"
                                                  method="POST" name="delete_item" style="display:none">
                                                <?php echo csrf_field(); ?>
                                                <?php echo e(method_field('DELETE')); ?>

                                            </form>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><?php echo app('translator')->get('labels.backend.hero_slider.manage_sequence'); ?></h3>
        </div>
        <div class="card-body">
            <?php if(count($slides_list) > 0): ?>
                <div class="row justify-content-center">
                    <div class="col-6  ">
                        <h4 class=""><?php echo app('translator')->get('labels.backend.hero_slider.sequence_note'); ?></h4>
                        <ul class="sorter d-inline-block">
                            <?php $__currentLoopData = $slides_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                            <span data-id="<?php echo e($item->id); ?>" data-sequence="<?php echo e($item->sequence); ?>">

                                <p class="title d-inline ml-2"><?php echo e($item->name); ?></p>
                           </span>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <a href="<?php echo e(route('admin.courses.index')); ?>"
                           class="btn btn-default border float-left"><?php echo app('translator')->get('strings.backend.general.app_back_to_list'); ?></a>

                        <a href="#" id="save_timeline"
                           class="btn btn-primary float-right"><?php echo app('translator')->get('labels.backend.hero_slider.save_sequence'); ?></a>

                    </div>

                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script src="<?php echo e(asset('plugins/amigo-sorter/js/amigo-sorter.min.js')); ?>"></script>

    <script>


        $(document).ready(function () {

            $('#myTable').DataTable({
                processing: true,
                serverSide: false,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 0,1, 2, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 0,1, 2, 4]
                        }
                    },
                    'colvis'
                ],

                columnDefs: [
                    {"width": "10%", "targets": 0},
                    {"width": "15%", "targets": 4},
                    {"className": "text-center", "targets": [0]}
                ],
                language:{
                    url : '<?php echo e(asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')); ?>',
                    buttons :{
                        colvis : '<?php echo e(trans("datatable.colvis")); ?>',
                        pdf : '<?php echo e(trans("datatable.pdf")); ?>',
                        csv : '<?php echo e(trans("datatable.csv")); ?>',
                    }
                }

            });
        });

        $('ul.sorter').amigoSorter({
            li_helper: "li_helper",
            li_empty: "empty",
        });
        $(document).on('click', '#save_timeline', function (e) {
            e.preventDefault();
            var list = [];
            $('ul.sorter li').each(function (key, value) {
                key++;
                var val = $(value).find('span').data('id');
                list.push({id: val, sequence: key});
            });

            $.ajax({
                method: 'POST',
                url: "<?php echo e(route('admin.sliders.saveSequence')); ?>",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    list: list
                }
            }).done(function () {
                location.reload();
            });
        })

        $(document).on('click', '.switch-input', function (e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "<?php echo e(route('admin.sliders.status')); ?>",
                data: {
                    _token:'<?php echo e(csrf_token()); ?>',
                    id: id,
                },
            }).done(function() {
                location.reload();
            });
        })
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/slider/index.blade.php ENDPATH**/ ?>