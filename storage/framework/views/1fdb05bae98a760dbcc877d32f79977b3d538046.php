<?php $__env->startSection('title', ($course->meta_title) ? $course->meta_title : app_name() ); ?>
<?php $__env->startSection('meta_description', $course->meta_description); ?>
<?php $__env->startSection('meta_keywords', $course->meta_keywords); ?>

<?php $__env->startPush('after-styles'); ?>
    <style>
        .leanth-course.go {
            right: 0;
        }
        .video-container iframe{
            max-width: 100%;
        }

    </style>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold"><span><?php echo e($course->title); ?></span></h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->

    <!-- Start of course details section
        ============================================= -->
    <section id="course-details" class="course-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <?php if(session()->has('danger')): ?>
                        <div class="alert alert-dismissable alert-danger fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo session('danger'); ?>

                        </div>
                    <?php endif; ?>
                    <?php if(session()->has('success')): ?>
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <div class="course-details-item border-bottom-0 mb-0">
                        <div class="course-single-pic mb30">
                            <?php if($course->course_image != ""): ?>
                                <img src="<?php echo e(asset('storage/uploads/'.$course->course_image)); ?>"
                                     alt="">
                            <?php endif; ?>
                        </div>
                        <div class="course-single-text">
                            <div class="course-title mt10 headline relative-position">
                                <h3><a href="<?php echo e(route('courses.show', [$course->slug])); ?>"><b><?php echo e($course->title); ?></b></a>
                                    <?php if($course->trending == 1): ?>
                                        <span class="trend-badge text-uppercase bold-font"><i
                                                    class="fas fa-bolt"></i> <?php echo app('translator')->get('labels.frontend.badges.trending'); ?></span>
                                    <?php endif; ?>

                                </h3>
                            </div>
                            <div class="course-details-content">
                                <p>
                                    <?php echo $course->description; ?>

                                </p>
                            </div>
                            <?php if($course->mediaVideo && $course->mediavideo->count() > 0): ?>
                                <div class="course-single-text">
                                    <?php if($course->mediavideo != ""): ?>
                                        <div class="course-details-content mt-3">
                                            <div class="video-container mb-5" data-id="<?php echo e($course->mediavideo->id); ?>">
                                                <?php if($course->mediavideo->type == 'youtube'): ?>


                                                    <div id="player" class="js-player" data-plyr-provider="youtube"
                                                         data-plyr-embed-id="<?php echo e($course->mediavideo->file_name); ?>"></div>
                                                <?php elseif($course->mediavideo->type == 'vimeo'): ?>
                                                    <div id="player" class="js-player" data-plyr-provider="vimeo"
                                                         data-plyr-embed-id="<?php echo e($course->mediavideo->file_name); ?>"></div>
                                                <?php elseif($course->mediavideo->type == 'upload'): ?>
                                                    <video poster="" id="player" class="js-player" playsinline controls>
                                                        <source src="<?php echo e($course->mediavideo->url); ?>" type="video/mp4"/>
                                                    </video>
                                                <?php elseif($course->mediavideo->type == 'embed'): ?>
                                                    <?php echo $course->mediavideo->url; ?>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>


                            <?php if(count($lessons)  > 0): ?>

                                <div class="course-details-category ul-li">
                                    <span class="float-none"><?php echo app('translator')->get('labels.frontend.course.course_timeline'); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /course-details -->
                    <div class="affiliate-market-guide mb65">

                        <div class="affiliate-market-accordion">
                            <div id="accordion" class="panel-group">
                                <?php if(count($lessons)  > 0): ?>
                                    <?php $count = 0; ?>
                                    <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($lesson->model && $lesson->model->published == 1): ?>
                                            <?php $count++ ?>

                                            <div class="panel position-relative">
                                                
                                                        <div class="position-absolute" style="right: 0;top:3px">
                                                        <?php 
                                                        
                                                            // $percent = $lesson->course->progress();
                                                            // if($lesson->model_type == 'App\Models\Test'){
                                                                $percent = (isset($percentage[$lesson->model->id]))?$percentage[$lesson->model->id]:'0';
                                                                $percent = round($percent,2);
                                                            // }
                                                        ?>
                                                            <span class="gradient-bg p-1 text-white font-weight-bold completed" style="border-radius: 0 0 0 4px!important;"><?php if($percent == '100'): ?> <?php echo app('translator')->get('labels.frontend.course.completed'); ?> <?php else: ?> <?php echo e($percent); ?>% <?php endif; ?></span>
                                                        </div>
                                                    
                                                <div class="panel-title" id="headingOne">
                                                    <div class="ac-head">
                                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                                                data-target="#collapse<?php echo e($count); ?>" aria-expanded="false"
                                                                aria-controls="collapse<?php echo e($count); ?>">
                                                            <span><?php echo e(sprintf("%02d", $count)); ?></span>
                                                            <?php echo e($lesson->model->title); ?>

                                                        </button>
                                                        <?php if($lesson->model_type == 'App\Models\Test'): ?>
                                                            <div class="leanth-course">
                                                                <a class="btn btn-sm btn-default" href="<?php echo e(route('lessons.show',['course_id' => $lesson->course->id,'slug'=>$lesson->model->slug,'test_id'=>$lesson->model->id])); ?>">
                                                                    <?php echo app('translator')->get('labels.frontend.course.test'); ?>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if($lesson->model->live_lesson): ?>
                                                            <div class="leanth-course">
                                                                <a class="btn btn-sm btn-default" href="<?php echo e(route('lessons.show',['course_id' => $lesson->course->id,'slug'=>$lesson->model->slug,'test_id'=>$lesson->model->id])); ?>">
                                                                    <?php echo app('translator')->get('labels.frontend.course.live_lesson'); ?>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <div id="collapse<?php echo e($count); ?>" class="collapse" aria-labelledby="headingOne"
                                                     data-parent="#accordion">
                                                    <div class="panel-body">
                                                        <?php if($lesson->model_type == 'App\Models\Test'): ?>
                                                            <?php echo e(mb_substr($lesson->model->description,0,20).'...'); ?>

                                                        <?php else: ?>
                                                            <?php if($lesson->model->live_lesson): ?>
                                                            <?php echo e(mb_substr($lesson->model->short_text,0,20).'...'); ?>

                                                            <?php else: ?>
                                                            <?php echo e($lesson->model->short_text); ?>

                                                            <?php endif; ?>

                                                        <?php endif; ?>
                                                        <?php if($lesson->model->live_lesson): ?>
                                                            <h4><?php echo app('translator')->get('labels.frontend.course.available_slots'); ?></h4>
                                                            <?php $__empty_1 = true; $__currentLoopData = $lesson->model->liveLessonSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <?php echo app('translator')->get('labels.frontend.course.date'); ?> <?php echo e($slot->start_at->format('d-m-Y h:i A')); ?>

                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        
                                                                <div>
                                                                    <a class="btn btn-default mt-3"
                                                                       href="<?php echo e(route('lessons.show',['course_id' => $lesson->course->id,'slug'=>$lesson->model->slug,'test_id'=>$lesson->model->id])); ?>">
                                                                        <span class=" text-white font-weight-bold "><?php echo app('translator')->get('labels.frontend.course.go'); ?>
                                                                            ></span>
                                                                    </a>
                                                                </div>
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- /market guide -->

                    
                    <!-- /review overview -->

                    

                    <?php if($course->bundles && (count($course->bundles) > 0)): ?>
                        <div class="course-details-category ul-li mt-5">
                            <h3 class="float-none text-dark"><?php echo app('translator')->get('labels.frontend.course.available_in_bundles'); ?></h3>
                        </div>
                        <div class="genius-post-item mb55">
                            <div class="tab-container">
                                <div id="tab1" class="tab-content-1 pt35">
                                    <div class="best-course-area best-course-v2">
                                        <div class="row">
                                            <?php $__currentLoopData = $course->bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bundle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <div class="col-md-4">
                                                    <div class="best-course-pic-text relative-position">
                                                        <div class="best-course-pic relative-position"
                                                             <?php if($bundle->course_image != ""): ?> style="background-image: url('<?php echo e(asset('storage/uploads/'.$course->course_image)); ?>')" <?php endif; ?>>

                                                            <?php if($bundle->trending == 1): ?>
                                                                <div class="trend-badge-2 text-center text-uppercase">
                                                                    <i class="fas fa-bolt"></i>
                                                                    <span><?php echo app('translator')->get('labels.frontend.badges.trending'); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php if($bundle->free == 1): ?>
                                                                <div class="trend-badge-3 text-center text-uppercase">
                                                                    <i class="fas fa-bolt"></i>
                                                                    <span><?php echo app('translator')->get('labels.backend.courses.fields.free'); ?></span>
                                                                </div>
                                                            <?php endif; ?>

                                                            <div class="course-rate ul-li">
                                                                <ul>
                                                                    <?php for($i=1; $i<=(int)$bundle->rating; $i++): ?>
                                                                        <li><i class="fas fa-star"></i></li>
                                                                    <?php endfor; ?>
                                                                </ul>
                                                            </div>
                                                            <div class="course-details-btn">
                                                                <a href="<?php echo e(route('bundles.show', [$bundle->slug])); ?>"><?php echo app('translator')->get('labels.frontend.course.bundle_detail'); ?>
                                                                    <i class="fas fa-arrow-right"></i></a>
                                                            </div>
                                                            <div class="blakish-overlay"></div>
                                                        </div>
                                                        <div class="best-course-text">
                                                            <div class="course-title mb20 headline relative-position">
                                                                <h3>
                                                                    <a href="<?php echo e(route('bundles.show', [$bundle->slug])); ?>"><?php echo e($bundle->title); ?></a>
                                                                </h3>
                                                            </div>
                                                            <div class="course-meta">
                                                            <span class="course-category"><a
                                                                        href="<?php echo e(route('courses.category',['category'=>$bundle->category->slug])); ?>"><?php echo e($bundle->category->name); ?></a></span>
                                                                <span class="course-author"><a href="#"><?php echo e($bundle->students()->count()); ?>

                                                                        <?php echo app('translator')->get('labels.frontend.course.students'); ?></a></span>
                                                                <span class="course-author mr-0"><?php echo e($bundle->courses()->count()); ?>

                                                                    <?php if($bundle->courses()->count() > 1 ): ?>
                                                                        <?php echo app('translator')->get('labels.frontend.course.courses'); ?>
                                                                    <?php else: ?>
                                                                        <?php echo app('translator')->get('labels.frontend.course.course'); ?>
                                                                    <?php endif; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- /course -->
                                        </div>
                                    </div>
                                </div><!-- /tab-1 -->
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-3">
                    <div class="side-bar">
                        <div class="course-side-bar-widget">


                            <?php if(!$purchased_course): ?>
                                <h3>
                                    <?php if($course->free == 1): ?>
                                        <span> <?php echo e(trans('labels.backend.courses.fields.free')); ?></span>
                                    <?php else: ?>
                                        <?php echo $course->CoursePageStrikePrice; ?>

                                        <?php echo app('translator')->get('labels.frontend.course.price'); ?><span>   <?php echo e($appCurrency['symbol'].' '.$course->price); ?></span>
                                    <?php endif; ?></h3>

                                <?php if(auth()->check() && (auth()->user()->hasRole('student')) && (Cart::session(auth()->user()->id)->get( $course->id))): ?>
                                    <button class="btn genius-btn btn-block text-center my-2 text-uppercase  btn-success text-white bold-font"
                                            type="submit"><?php echo app('translator')->get('labels.frontend.course.added_to_cart'); ?>
                                    </button>

                                <?php elseif(!auth()->check()): ?>
                                    <?php if($course->free == 1): ?>
                                        <a id="openLoginModal"
                                           class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                           data-target="#myModal" href="#"><?php echo app('translator')->get('labels.frontend.course.get_now'); ?> <i
                                                    class="fas fa-caret-right"></i></a>
                                    <?php else: ?>
                                        <a id="openLoginModal"
                                           class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                           data-target="#myModal" href="#"><?php echo app('translator')->get('labels.frontend.course.buy_now'); ?> <i
                                                    class="fas fa-caret-right"></i></a>

                                        <a id="openLoginModal"
                                           class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase "
                                           data-target="#myModal" href="#"><?php echo app('translator')->get('labels.frontend.course.add_to_cart'); ?> <i
                                                    class="fa fa-shopping-bag"></i></a>

                                        <a id="openLoginModal"
                                           class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                           data-target="#myModal" href="#"><?php echo app('translator')->get('labels.frontend.course.subscribe'); ?></a>
                                    <?php endif; ?>
                                <?php elseif(auth()->check() && (auth()->user()->hasRole('student'))): ?>

                                    <?php if($course->free == 1): ?>
                                        <form action="<?php echo e(route('cart.getnow')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>"/>
                                            <input type="hidden" name="amount" value="<?php echo e(($course->free == 1) ? 0 : $course->price); ?>"/>
                                            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                    href="#"><?php echo app('translator')->get('labels.frontend.course.get_now'); ?> <i
                                                        class="fas fa-caret-right"></i></button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('cart.checkout')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>"/>
                                            <input type="hidden" name="amount" value="<?php echo e(($course->free == 1) ? 0 : $course->price); ?>"/>
                                            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                    href="#"><?php echo app('translator')->get('labels.frontend.course.buy_now'); ?> <i
                                                        class="fas fa-caret-right"></i></button>
                                        </form>
                                        <form action="<?php echo e(route('cart.addToCart')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>"/>
                                            <input type="hidden" name="amount" value="<?php echo e(($course->free == 1) ? 0 : $course->price); ?>"/>
                                            <button type="submit"
                                                    class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase ">
                                                <?php echo app('translator')->get('labels.frontend.course.add_to_cart'); ?> <i
                                                        class="fa fa-shopping-bag"></i></button>
                                        </form>
                                        <?php if(auth()->user()->subscription('default')): ?>
                                        <form action="<?php echo e(route('subscription.course_subscribe')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>"/>
                                            <input type="hidden" name="amount" value="<?php echo e(($course->free == 1) ? 0 : $course->price); ?>"/>
                                            <button type="submit"
                                                    class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font">
                                                <?php echo app('translator')->get('labels.frontend.course.subscribe'); ?></button>
                                        </form>
                                        <?php else: ?>
                                        <a class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                           href="<?php echo e(route('subscription.plans')); ?>"><?php echo app('translator')->get('labels.frontend.course.subscribe'); ?></a>
                                        <?php endif; ?>
                                    <?php endif; ?>


                                <?php else: ?>
                                    <h6 class="alert alert-danger"> <?php echo app('translator')->get('labels.frontend.course.buy_note'); ?></h6>
                                <?php endif; ?>
                                <?php echo $__env->make('frontend.layouts.partials.wishlist',['course' => $course->id, 'price' => $course->price], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php else: ?>

                                <?php if($continue_course): ?>
                                    <a href="<?php echo e(route('lessons.show',['course_id' => $course->id,'slug'=>$continue_course->model->slug])); ?>"
                                       class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font">

                                        <?php echo app('translator')->get('labels.frontend.course.continue_course'); ?>

                                        <i class="fa fa-arow-right"></i></a>
                                <?php endif; ?>

                            <?php endif; ?>

                        </div>
                        <div class="enrolled-student">
                            <div class="comment-ratting float-left ul-li">
                                <ul>
                                    <?php for($i=1; $i<=(int)$course->rating; $i++): ?>
                                        <li><i class="fas fa-star"></i></li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                            <div class="student-number bold-font">
                                <?php echo e($course->students()->count()); ?>  <?php echo app('translator')->get('labels.frontend.course.enrolled'); ?>
                            </div>
                        </div>
                        <div class="couse-feature ul-li-block">
                            <ul>
                                <li > <?php echo app('translator')->get('labels.frontend.course.chapters'); ?>
                                    <span>  <?php echo e($course->chapterCount()); ?> </span></li>
                                
                                
                            </ul>

                        </div>

                        <?php if($recent_news->count() > 0): ?>
                            <div class="side-bar-widget">
                                <h2 class="widget-title text-capitalize"><?php echo app('translator')->get('labels.frontend.course.recent_news'); ?></h2>
                                <div class="latest-news-posts">
                                    <?php $__currentLoopData = $recent_news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="latest-news-area">
                                            <?php if($item->image != ""): ?>
                                                <div class="latest-news-thumbnile relative-position"
                                                     style="background-image: url(<?php echo e(asset('storage/uploads/'.$item->image)); ?>)">
                                                    <div class="blakish-overlay"></div>
                                                </div>
                                            <?php endif; ?>


                                            <div class="date-meta">
                                                <i class="fas fa-calendar-alt"></i> <?php echo e($item->created_at->format('d M Y')); ?>

                                            </div>
                                            <h3 class="latest-title bold-font"><a
                                                        href="<?php echo e(route('blogs.index',['slug'=>$item->slug.'-'.$item->id])); ?>"><?php echo e($item->title); ?></a>
                                            </h3>
                                        </div>
                                        <!-- /post -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    <div class="view-all-btn bold-font">
                                        <a href="<?php echo e(route('blogs.index')); ?>"><?php echo app('translator')->get('labels.frontend.course.view_all_news'); ?>
                                            <i class="fas fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                        <?php if($global_featured_course != ""): ?>
                            <div class="side-bar-widget">
                                <h2 class="widget-title text-capitalize"><?php echo app('translator')->get('labels.frontend.course.featured_course'); ?></h2>
                                <div class="featured-course">
                                    <div class="best-course-pic-text relative-position pt-0">
                                        <div class="best-course-pic relative-position "
                                             <?php if($global_featured_course->course_image != ""): ?> style="background-image: url(<?php echo e(asset('storage/uploads/'.$global_featured_course->course_image)); ?>)" <?php endif; ?>>

                                            <?php if($global_featured_course->trending == 1): ?>
                                                <div class="trend-badge-2 text-center text-uppercase">
                                                    <i class="fas fa-bolt"></i>
                                                    <span><?php echo app('translator')->get('labels.frontend.badges.trending'); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($global_featured_course->free == 1): ?>
                                                <div class="trend-badge-3 text-center text-uppercase">
                                                    <i class="fas fa-bolt"></i>
                                                    <span><?php echo app('translator')->get('labels.backend.courses.fields.free'); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="best-course-text" style="left: 0;right: 0;">
                                            <div class="course-title mb20 headline relative-position">
                                                <h3>
                                                    <a href="<?php echo e(route('courses.show', [$global_featured_course->slug])); ?>"><?php echo e($global_featured_course->title); ?></a>
                                                </h3>
                                            </div>
                                            <div class="course-meta">
                                                <span class="course-category"><a
                                                            href="<?php echo e(route('courses.category',['category'=>$global_featured_course->category->slug])); ?>"><?php echo e($global_featured_course->category->name); ?></a></span>
                                                <span class="course-author"><?php echo e($global_featured_course->students()->count()); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of course details section
        ============================================= -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script>

    <script>
        const player = new Plyr('#player');

        $(document).on('change', 'input[name="stars"]', function () {
            $('#rating').val($(this).val());
        })
        <?php if(isset($review)): ?>
            var rating = "<?php echo e($review->rating); ?>";
            $('input[value="' + rating + '"]').prop("checked", true);
            $('#rating').val(rating);
        <?php endif; ?>
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app'.config('theme_layout'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/courses/course.blade.php ENDPATH**/ ?>