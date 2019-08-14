@extends('layouts.frontend.index')
@section('content')
<link rel="stylesheet" href="{{ asset('frontend/vendor/rating/rateyo.css') }}">
<!-- content start -->
<div class="container-fluid p-0 home-content">
    <!-- banner start -->
    <div class="subpage-slide-blue">
        <div class="container">
            <h1>Course</h1>
        </div>
    </div>
    <!-- banner end -->
    
    <!-- breadcrumb start -->
        <div class="breadcrumb-container">
            <div class="container">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('my.courses') }}">My Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $course->course_title }}</li>
              </ol>
            </div>
        </div>
    
    <!-- breadcrumb end -->
    
    <div class="container">
        <div class="row mt-4">
            <!-- course block start -->
            <div class="col-xl-9 col-lg-9 col-md-8">
                    <div class="cv-course-container">
                    <h4>{{ $course->course_title }}</h4>
                    <div class="instructor-clist m-0">
                        <div class="col-md-12 p-0 m-0">
                            <i class="fa fa-chalkboard-teacher"></i>&nbsp;
                            <span>Created by <b>{{ $course->instructor->first_name.' '.$course->instructor->last_name }}</b></span>
                        </div>
                    </div>
                    <div class="row cv-header">
                        
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6  col-6">
                            <div class="cv-category-icon">
                                <i class="far fa-bookmark"></i>
                            </div>
                            <div class="cv-category-detail">
                                <span>Category</span>
                                <br>
                                {{ $course->category->name }}
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6  col-6">
                            <div class="cv-category-detail cv-rating float-lg-left float-md-right float-sm-right">
                                <span>{{ $course->ratings->count('rating') }} Reviews</span>
                                <br>
                                <star class="course-rating">
                                    @for($r=1;$r<=5;$r++)
                                        <span class="fa fa-star {{ $r <= $course->ratings->avg('rating') ? 'checked-vpage' : ''}}"></span>
                                    @endfor
                                </star>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="cv-category-detail cv-price">
                            	@php $course_price = $course->price ? $course->price : '0.00'; @endphp
                                <h4>{{  config('config.default_currency').$course_price }}</h4>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 float-md-right col-sm-6 float-sm-right col-6">
                            <div class="cv-category-detail cv-enroll float-lg-right float-md-right float-sm-right">
                                <a href="javascript::void(0);" class="btn btn-ulearn-cview mt-1" data-toggle="modal" data-target="#rateModal">RATE COURSE</a>
                            </div>
                        </div>
                    </div>

                    
                    @if($is_curriculum)
                    <!-- curriculum block start -->
                    <h4 class="mt-4">Curriculum</h4>

                    <div class="accordion mt-3" id="accordionExample">
                      
                     @foreach($curriculum_sections as $curriculum_section => $curriculum_lectures)
                      <?php 
                      	$section_split = explode('{#-#}', $curriculum_section);
                      	$section_id = $section_split[0];
                      	$section_name = $section_split[1];
                      ?>
                      <div class="card mb-2">
                        <div class="card-header" id="headingOne-{{ $section_id }}">
                          <h5 class="mb-0">
                            <button class="btn btn-acc-head" type="button" data-toggle="collapse" data-target="#collapseOne-{{ $section_id }}" aria-expanded="true" aria-controls="collapseOne-{{ $section_id }}">
                              <i class="fas @if($loop->first) fa-minus @else fa-plus @endif accordian-icon mr-2" ></i><span>{{ $section_name }}</span>
                            </button>
                          </h5>
                        </div>

                        <div id="collapseOne-{{ $section_id }}" class="collapse @if($loop->first) show @endif" aria-labelledby="headingOne-{{ $section_id }}" data-parent="#accordionExample">
                          <div class="container">
                            
                          @foreach($curriculum_lectures as $curriculum_lecture)
                          	@php
                          		switch ($curriculum_lecture->media_type) {
								    case 0:
								        $icon_class = 'fas fa-video';
								        break;
								    case 1:
								        $icon_class = 'fas fa-headphones';
								        break;
								    case 2:
								        $icon_class = 'far fa-file-pdf';
								        break;
								    case 3:
								        $icon_class = 'far fa-file-alt';
								        break;
								    default:
								        $icon_class = 'fas fa-video';
								}
                          	@endphp
                            <div class="row lecture-container">
                                <div class="col-7 my-auto ml-4">
                                    <i class="{{ $icon_class }} mr-2"></i>
                                    <span>{{ $curriculum_lecture->l_title }}</span>
                                </div>
                                @php
                                    $is_completed = SiteHelpers::getCoursecompletedStatus($curriculum_lecture->lecture_quiz_id);
                                @endphp
                                <div class="col-3 my-auto">
                                    <article  class="preview-time">
                                        <span class="mr-3">
                                        	@if($curriculum_lecture->media_type == 2)
                                        		{{ $curriculum_lecture->f_duration.' Page(s)' }}
                                        	@elseif($curriculum_lecture->media_type == 0 || $curriculum_lecture->media_type == 1)
                                        		@if($curriculum_lecture->media_type == 0)
                                        			{{ $curriculum_lecture->v_duration }}
                                        		@else
                                        			{{ $curriculum_lecture->f_duration }}
                                        		@endif
                                            
                                        	@endif
                                        </span>
                                        <a href="{{ url('course-enroll/'.$course->course_slug.'/'.SiteHelpers::encrypt_decrypt($curriculum_lecture->lecture_quiz_id,true)) }}" class="btn btn-ulearn-preview">
                                        @if($is_completed)
                                        RESTART
                                        @else
                                        START
                                        @endif
                                        </a>
                                    </article>
                                </div>
                                <div class="col-1 my-auto">
                                @if($is_completed)
                                <i class="fas fa-check-circle" style=color:green;></i>
                                @endif
                                </div>
                            </div>
                          @endforeach  
                          </div>
                        </div>
                      </div>
                      @endforeach
                      
					</div>
                    <!-- curriculum block end -->
                    @endif
                </div>
            </div>
            <!-- course block end -->

            <!-- course sidebar start -->
            <div class="col-xl-3 col-lg-3 col-md-4 d-none d-md-block">
                <section class="course-feature">
                    <header>
                        <h6>COURSE FEATURES</h6>
                    </header>

                    <div class="cf-pricing">
                        <span>PRICING:</span>
                        <button class="cf-pricing-btn btn">{{ $course->price == '' || $course_price == 0.00 ? 'FREE' : 'PAID' }}</button>
                    </div>

                    <ul class="list-unstyled cf-pricing-li">
                        <li><i class="far fa-user"></i>{{ $students_count }} Student(s)</li>
                        <li><i class="far fa-clock"></i>Duration: {{ $course->duration ? $course->duration : '-' }}</li>
                        <li><i class="fas fa-bullhorn"></i>Lectures: {{ $lectures_count }}</li>
                        <li><i class="far fa-play-circle"></i>Videos: {{ $videos_count }}</li>
                        <li><i class="far fa-address-card"></i>Certificate of Completion</li>
                        <li><i class="fas fa-file-download"></i>Downloadable Resources</li>
                    </ul>
                </section>
                
                @if($video)
                <h6 class="underline-heading mt-3">COURSE INTRO</h6>
                <section class="course_preview_video mt-3">
                    <div class="aligncenter overlay">
                    	
	                      @php
	                        $file_name = 'course/'.$video->course_id.'/'.$video->video_title.'.'.$video->video_type;
	                        $file_image_name = 'course/'.$video->course_id.'/'.$video->image_name;
	                      @endphp
	                     
                        <a href="#myVideo" class="btn-play far fa-play-circle lightbox"></a>
                        <video controls id="myVideo" style="display:none;">
						    <source src="{{ Storage::url($file_name) }}" type="video/mp4">
						    Your browser doesn't support HTML5 video tag.
						</video>
                        <img src="@if(Storage::exists($file_image_name)){{ Storage::url($file_image_name) }}@else{{ asset('backend/assets/images/course_detail.jpg') }}@endif" alt="image description">
                    </div>
                </section>
                @endif
                
                <h6 class="mt-4 underline-heading">COURSE CATEGORIES</h6>
                <ul class="ul-no-padding">
                	@php $categories = SiteHelpers::active_categories(); @endphp
                    @foreach ($categories as $category)
			            <li class="my-1">
			                {{ $category->name}}
			            </li>
			        @endforeach
                </ul>

                @if($course->keywords)
                <section class="tags-container mt-3">
                    <h6 class="underline-heading">TAGS</h6>
                    <ul class="list-unstyled tag-list mt-3">
                    @php
                    	$tags = explode(',', $course->keywords);
                    @endphp
                    @foreach($tags as $tag)
                        <li><a href="javascript:void();">{{ $tag }}</a></li>
                    @endforeach
                    </ul>
                </section>
                @endif
            </div>
            <!-- course sidebar end -->
        </div>
    </div>
    
<!-- content end -->

<!-- The Modal start -->
<div class="modal" id="rateModal">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header bi-header ">
        <h5 class="col-12 modal-title text-center bi-header-seperator-head">Rate the Course</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
       
    <div class="becomeInstructorForm">
       <form id="rateCourseForm" class="form-horizontal" method="POST" action="{{ route('course.rate') }}">
        {{ csrf_field() }}
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <input type="hidden" name="rating" id="rating" value="{{ $course_rating->rating }}">
        <input type="hidden" name="rating_id" value="{{ $course_rating->id }}">
            <div class="px-4 py-2">
                <div class="form-group">
                    <label>Your Rating</label>
                    <div class="row">
                        <div class="col-7 pl-2">
                            <div id="rateYo"></div>
                        </div>
                        <div class="col-5">
                            @if($course_rating->id)
                                <a class="btn btn-sm btn-block delete-review delete-record" href="{{ route('delete.rating', $course_rating->id) }}">Delete Review</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Your Review</label>
                    <textarea class="form-control form-control" placeholder="Comments" name="comments">{{ $course_rating->comments }}</textarea>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-lg btn-block login-page-button">{{ $course_rating->id ? 'Update' : 'Add' }} Review</button>
                </div>

            </div>
            </form>
        </div>
    </div>
  </div>
</div>
<!-- The Modal end -->
@endsection

@section('javascript')
<script src="{{ asset('frontend/vendor/rating/rateyo.js') }}"></script>
<script type="text/javascript">
function toggleIcon(e) 
{
    $(e.target)
        .prev('.card-header')
        .find(".accordian-icon")
        .toggleClass('fa-plus fa-minus');
}
$('.accordion').on('hidden.bs.collapse', toggleIcon);
$('.accordion').on('shown.bs.collapse', toggleIcon);

// lightbox init
function initFancybox() {
"use strict";

$('a.lightbox, [data-fancybox]').fancybox({
  parentEl: 'body',
  margin: [50, 0]
});
}

$(document).ready(function()
{
    initFancybox();

    $("#rateYo").rateYo({
        @if($course_rating->id)
            rating: '{{ $course_rating->rating }}',
        @endif
        halfStar: true,
        ratedFill: "#00a500",
        starWidth: "25px",
        onChange: function (rating, rateYoInstance) {
            $('#rating').val(rating);
        }
    });
});
</script>
@endsection