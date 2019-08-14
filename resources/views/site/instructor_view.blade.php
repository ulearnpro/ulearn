@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>{{ $instructor->first_name.' '.$instructor->last_name }}</h1>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
            <div class="breadcrumb-container">
                <div class="container">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('instructor.list') }}">Instructor</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $instructor->first_name.' '.$instructor->last_name }}</li>
                  </ol>
                </div>
            </div>
        
        <!-- breadcrumb end -->
        
        <div class="container mt-5">
            <div class="row mt-4">
                <div class="col-xl-3 col-lg-4 col-md-5 d-none d-md-block">
                    <div class="instructor-profile-box mx-auto">
                        <main>
                            <img src="@if(Storage::exists($instructor->instructor_image)){{ Storage::url($instructor->instructor_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif">
                            <div class="col-12">
                                <ul class="list-unstyled social-icons">
                                    <li>
                                        <a href="{{ $instructor->link_facebook }}" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $instructor->link_linkedin }}" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $instructor->link_twitter }}" target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="{{ $instructor->link_googleplus }}" target="_blank">
                                            <i class="fab fa-google-plus-g"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <ul class="list-unstyled cf-pricing-li">
                                <li><i class="fa fa-chalkboard"></i>{{ $metrics['courses'] }} Courses</li>
                                <li><i class="fas fa-bullhorn"></i>Lectures: {{ $metrics['lectures'] }}</li>
                                <li><i class="far fa-play-circle"></i>Videos: {{ $metrics['videos'] }}</li>
                            </ul>
                        </main>
                    </div>

                    <div class="rightRegisterForm ml-0">
                        <div class="box-header">
                            Drop a Message
                        </div>
                        <div class="px-4 py-2">
                            <form class="form-horizontal" method="POST" action="{{ route('contact.instructor') }}" id="instructorForm">
                                {{ csrf_field() }}
                                <input type="hidden" name="instructor_email" value="{{ $instructor->contact_email }}">
                                <div class="form-group">
                                    <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Name" name="full_name">
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Email ID</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Email ID" name="email_id">
                                </div>

                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control form-control" placeholder="Message" name="message"></textarea>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-lg btn-block login-page-button">Send Message</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-7">
                    <h4>{{ $instructor->first_name.' '.$instructor->last_name }}</h4>
                    <div class="row inst-block">
                        <div class="instructor-contact col-xl-4 col-lg-4 col-md-6 col-sm-6">
                            <i class="fas fa-phone-volume"></i>
                            <span>{{ $instructor->telephone }}</span>
                        </div>
                        <div class="instructor-contact col-xl-4 col-lg-4 col-md-6 col-sm-6">
                            <i class="fas fa-mobile-alt"></i>
                            <span>{{ $instructor->mobile }}</span>
                        </div>
                        <div class="instructor-contact col-xl-4 col-lg-4 col-md-6 col-sm-6">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $instructor->contact_email }}</span>
                        </div>
                    </div>

                    <h4 class="mt-4">Biography</h4>
                    {!! $instructor->biography !!}
                    <hr class="mt-4">
                    @if(count($instructor->courses) > 0)
                    <div class="row">
                        <div class="col-12 text-center seperator-head mt-0">
                            <h4>Courses</h4>
                            <p class="mt-3">Courses taught by {{ $instructor->first_name.' '.$instructor->last_name }}</p>
                        </div>
                    </div>

                    <!-- course start -->
                    <div class="row">
                    @foreach($instructor->courses as $course)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
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
                    <!-- course end -->
                    @endif
                </div>
            </div>
        </div>
        
    <!-- content end -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function()
{
    $("#instructorForm").validate({
            rules: {
                full_name: {
                    required: true
                },
                email_id:{
                    required: true,
                    email:true
                },
                message:{
                    required: true
                }
            },
            messages: {
                full_name: {
                    required: 'This field is required.'
                },
                email_id: {
                    required: 'This field is required.',
                    email: 'Please enter valid Email ID'
                },
                message: {
                    required: 'This field is required.'
                }
            }
        });

});
</script>
@endsection