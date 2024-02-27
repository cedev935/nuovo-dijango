<?php $__env->startSection('title', trans('labels.frontend.course.courses').' | '. app_name() ); ?>

<?php $__env->startPush('after-styles'); ?>
    <style>
        .couse-pagination li.active {
            color: #333333 !important;
            font-weight: 700;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color: white;
            border: none;

        }
     .listing-filter-form select{
            height:50px!important;
        }

        ul.pagination {
            display: inline;
            text-align: center;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">
                        <span><?php if(isset($category)): ?> <?php echo e($category->name); ?> <?php else: ?> <?php echo app('translator')->get('labels.frontend.course.courses'); ?> <?php endif; ?> </span>
                    </h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->


    <!-- Start of course section
        ============================================= -->
    <section id="course-page" class="course-page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if(session()->has('success')): ?>
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <div class="short-filter-tab">
                        <div class="shorting-filter w-50 d-inline float-left mr-3">
                            <span><?php echo app('translator')->get('labels.frontend.course.sort_by'); ?></span>
                            <select id="sortBy" class="form-control d-inline w-50">
                                <option value=""><?php echo app('translator')->get('labels.frontend.course.none'); ?></option>
                                <option value="popular"><?php echo app('translator')->get('labels.frontend.course.popular'); ?></option>
                                <option value="trending"><?php echo app('translator')->get('labels.frontend.course.trending'); ?></option>
                                <option value="featured"><?php echo app('translator')->get('labels.frontend.course.featured'); ?></option>
                            </select>
                        </div>

                        <div class="tab-button blog-button ul-li text-center float-right">
                            <ul class="product-tab">
                                <li class="active" rel="tab1"><i class="fas fa-th"></i></li>
                                <li rel="tab2"><i class="fas fa-list"></i></li>
                            </ul>
                        </div>

                    </div>

                    <div class="genius-post-item">
                        <div class="tab-container">
                            <div id="tab1" class="tab-content-1 pt35">
                                <div class="best-course-area best-course-v2">
                                    <div class="row">
                                        <?php if($courses->count() > 0): ?>

                                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <div class="col-md-4">
                                                    <div class="best-course-pic-text relative-position">
                                                        <div class="best-course-pic relative-position"
                                                             <?php if($course->course_image != ""): ?> style="background-image: url('<?php echo e(asset('storage/uploads/'.$course->course_image)); ?>')" <?php endif; ?>>

                                                            <?php if($course->trending == 1): ?>
                                                                <div class="trend-badge-2 text-center text-uppercase">
                                                                    <i class="fas fa-bolt"></i>
                                                                    <span><?php echo app('translator')->get('labels.frontend.badges.trending'); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                                <?php if($course->free == 1): ?>
                                                                    <div class="trend-badge-3 text-center text-uppercase">
                                                                        <i class="fas fa-bolt"></i>
                                                                        <span><?php echo app('translator')->get('labels.backend.courses.fields.free'); ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <div class="course-price text-center gradient-bg">
                                                                <?php if($course->free == 1): ?>
                                                                    <span><?php echo e(trans('labels.backend.courses.fields.free')); ?></span>
                                                                <?php else: ?>
                                                                    <span>
                                                                        <?php echo $course->strikePrice; ?>

                                                                        <?php echo e($appCurrency['symbol'].' '.$course->price); ?>

                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>

                                                            <div class="course-rate ul-li">
                                                                <ul>
                                                                    <?php for($i=1; $i<=(int)$course->rating; $i++): ?>
                                                                        <li><i class="fas fa-star"></i></li>
                                                                    <?php endfor; ?>
                                                                </ul>
                                                            </div>
                                                            <div class="course-details-btn">
                                                                <a href="<?php echo e(route('courses.show', [$course->slug])); ?>"><?php echo app('translator')->get('labels.frontend.course.course_detail'); ?>
                                                                    <i class="fas fa-arrow-right"></i></a>
                                                            </div>
                                                            <div class="blakish-overlay"></div>
                                                        </div>
                                                        <div class="best-course-text">
                                                            <div class="course-title mb20 headline relative-position">
                                                                <h3>
                                                                    <a href="<?php echo e(route('courses.show', [$course->slug])); ?>"><?php echo e($course->title); ?></a>
                                                                </h3>
                                                            </div>
                                                            
                                                            <?php echo $__env->make('frontend.layouts.partials.wishlist',['course' => $course->id, 'price' => $course->price], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <h3><?php echo app('translator')->get('labels.general.no_data_available'); ?></h3>
                                    <?php endif; ?>

                                    <!-- /course -->

                                    </div>
                                </div>
                            </div><!-- /tab-1 -->

                            <div id="tab2" class="tab-content-1">
                                <div class="course-list-view">
                                    <table>
                                        <tr class="list-head">
                                            <th><?php echo app('translator')->get('labels.frontend.course.course_name'); ?></th>
                                            <th><?php echo app('translator')->get('labels.frontend.course.course_type'); ?></th>
                                            <th><?php echo app('translator')->get('labels.frontend.course.starts'); ?></th>
                                        </tr>
                                        <?php if($courses->count() > 0): ?>
                                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <tr>
                                                    <td>
                                                        <div class="course-list-img-text">
                                                            <div class="course-list-img"
                                                                 <?php if($course->course_image != ""): ?> style="background-image: url(<?php echo e(asset('storage/uploads/'.$course->course_image)); ?>)" <?php endif; ?> >
                                                            </div>
                                                            <div class="course-list-text">
                                                                <h3>
                                                                    <a href="<?php echo e(route('courses.show', [$course->slug])); ?>"><?php echo e($course->title); ?></a>
                                                                </h3>
                                                                
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="course-type-list">
                                                            <span><a href="<?php echo e(route('courses.category',['category'=>$course->category->slug])); ?>"><?php echo e($course->category->name); ?></a></span>
                                                        </div>
                                                    </td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($course->start_date)->format('d M Y')); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3">
                                                    <h3><?php echo app('translator')->get('labels.general.no_data_available'); ?></h3>

                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                    </table>
                                </div>
                            </div><!-- /tab-2 -->
                        </div>
                        <div class="couse-pagination text-center ul-li">
                            <?php echo e($courses->links()); ?>

                        </div>
                    </div>


                </div>

                
            </div>
        </div>
    </section>
    <!-- End of course section
        ============================================= -->

    <!-- Start of best course
   =============================================  -->
    <?php echo $__env->make('frontend.layouts.partials.browse_courses', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- End of best course
            ============================================= -->


<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script>
        $(document).ready(function () {
            $(document).on('change', '#sortBy', function () {
                if ($(this).val() != "") {
                    location.href = '<?php echo e(url()->current()); ?>?type=' + $(this).val();
                } else {
                    location.href = '<?php echo e(route('courses.all')); ?>';
                }
            })

            <?php if(request('type') != ""): ?>
            $('#sortBy').find('option[value="' + "<?php echo e(request('type')); ?>" + '"]').attr('selected', true);
            <?php endif; ?>
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app'.config('theme_layout'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/courses/index.blade.php ENDPATH**/ ?>