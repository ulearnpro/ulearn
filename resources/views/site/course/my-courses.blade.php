@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>My Courses</h1>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
        <div class="breadcrumb-container">
            <div class="container">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Courses</li>
              </ol>
            </div>
        </div>
        
        <!-- breadcrumb end -->

        <!-- course list start -->
        <div class="container" id="my-courses">
            <div class="row">
            @if(count($courses)> 0 )
            @foreach($courses as $course)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="course-block mx-auto">
                        <a href="{{ route('course.learn', $course->course_slug) }}" class="c-view">
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
                                        <?php for ($r=1;$r<=5;$r++) { ?>
                                            <span class="fa fa-star <?php echo $r <= 4 ? 'checked' : '';?>"></span>
                                        <?php }?>
                                        </star>
                                    </div>
                                </div>
                            </footer>
                        </a>    
                        </div>
                    </div>
                @endforeach
            @else
                <article class="container not-found-block">
                    <div class="row">
                    <div class="col-12 not-found-col">
                            <span><b>2<span class="blue">0</span>4</b></span>
                            <h3>Sorry! No courses added to your account</h3>
                            <a href="{{ route('course.list') }}" class="btn btn-ulearn-cview mt-3">Explore Courses</a>
                    </div>
                    </div>
                </article>
            @endif                             
            </div>
            </div>
            
        </div>
        <!-- course list end -->
@endsection