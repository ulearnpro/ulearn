@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="homepage-slide-blue">
            <h1>{{ Sitehelpers::get_option('pageHome', 'banner_title') }}</h1>
            <span class="title-sub-header">{{ Sitehelpers::get_option('pageHome', 'banner_text') }}</span>
            <form method="GET" action="{{ route('course.list') }}">
            <div class="searchbox-contrainer col-md-6 mx-auto">
                <input name="keyword" type="text" class="searchbox d-none d-sm-inline-block" placeholder="Search for courses by course titles"><input name="keyword" type="text" class="searchbox d-inline-block d-sm-none" placeholder="Search for courses"><button type="submit" class="searchbox-submit"><i class="fa fa-search"></i></button>
            </div>
            </form>
        </div>
        <!-- banner end -->

        <?php 
            $tabs = array('latestTab' => 'Latest Courses',
                          'freeTab' => 'Free Courses',
                          'discountTab' => 'Discount Courses',
                        );
        ?>
        <nav class="clearfix secondary-nav seperator-head">
            <ul class="secondary-nav-ul list mx-auto nav">
                 <?php foreach ($tabs as $tab_key => $tab_value) { ?>
                     <li class="nav-item">
                         <a data-toggle="tab" role="tab" href="<?php echo '#'.$tab_key;?>" class="nav-link <?php echo $tab_key == 'latestTab' ? 'active' : '';?>"><?php echo $tab_value;?></a>
                     </li>
                 <?php }?>
            </ul>
        </nav>

        <!-- course list start -->
        <div class="container tab-content">
            <?php foreach ($tabs as $tab_key => $tab_value) { ?>
             <div class="<?php echo $tab_key == 'latestTab' ? 'tab-pane fade show active' : 'tab-pane fade';?>" id="<?php echo $tab_key;?>" role="tabpanel">

             <div class="row">
               @foreach(${$tab_key.'_courses'} as $course)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        
                        <div class="course-block mx-auto">
                            <a href="{{ route('course.view', $course->course_slug) }}">
                                <main>
                                    <img src="@if(Storage::exists($course->thumb_image)){{ Storage::url($course->thumb_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif">
                                    <div class="col-md-12"><h6 class="course-title">{{ $course->course_title }}</h6></div>
                                    
                                    <div class="instructor-clist">
                                        <div class="col-md-12">
                                            <i class="fa fa-chalkboard-teacher"></i>&nbsp;
                                            <span>Created by <b>{{ $course->first_name.' '.$course->last_name }}</b></span>
                                        </div>
                                    </div>
                                </main>
                                <footer>
                                    <div class="c-row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            @php $course_price = $course->price ? config('config.default_currency').$course->price : 'Free'; @endphp
                                            <h5 class="course-price">{{  $course_price }}&nbsp;<s>{{ $course->strike_out_price ? $course->strike_out_price : '' }}</s></h5>
                                        </div>
                                        <div class="col-md-5 offset-md-1 col-sm-5 offset-sm-1 col-5 offset-1">
                                            <star class="course-rating">
                                            @for ($r=1;$r<=5;$r++)
                                                <span class="fa fa-star {{ $r <= $course->average_rating ? 'checked' : '' }}"></span>
                                            @endfor
                                            </star>
                                        </div>
                                    </div>
                                </footer>
                            </a>    
                        </div>
                        
                    </div>
                @endforeach
            </div>

            </div>
            <?php }?>

        </div>
        <!-- course list end -->

        <!-- dummy block start -->
        <article class="learn-block">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <h3 class="dblock-heading">{{ Sitehelpers::get_option('pageHome', 'learn_block_title') }}</h3>
                        <p class="dblock-text">{!! Sitehelpers::get_option('pageHome', 'learn_block_text') !!}</p>
                        <a href="{{ route('course.list') }}" class="btn btn-ulearn">Explore Courses</a>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 vertical-align">
                        <img class="img-fluid mt-5 mx-auto" src="{{ asset('frontend/img/landing.png') }}">
                    </div>
                </div>
            </div>
        </article>
        <!-- dummy block end -->

        <!-- instructor block start -->
        <article class="instructor-block">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center seperator-head mt-3">
                        <h3>Our Instructors</h3>
                        <p class="mt-3">{{ Sitehelpers::get_option('pageHome', 'instructor_text') }}</p>
                    </div>
                </div>
                
                <div class="row mt-4 mb-5">
                    @foreach ($instructors as $instructor) 
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="instructor-box mx-auto text-center">
                        <a href="{{ route('instructor.view', $instructor->instructor_slug) }}">
                            <main>
                                <img src="@if(Storage::exists($instructor->instructor_image)){{ Storage::url($instructor->instructor_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif">
                                <div class="col-md-12">
                                    <h6 class="instructor-title">{{ $instructor->first_name.' '.$instructor->last_name }}</h6>
                                    <p>{!! mb_strimwidth($instructor->biography, 0, 120, ".....") !!}</p>
                                </div>
                            </main>
                        </a>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </article>
        <!-- instructor block end -->

    </div>
    <!-- content end -->
@endsection