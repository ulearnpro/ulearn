@extends('layouts.frontend.index')
@section('content')
    <!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>Instructors</h1>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
            <div class="breadcrumb-container">
                <div class="container">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Instructors</li>
                  </ol>
                </div>
            </div>
        
        
        <div class="container mt-5">
            <!-- instructor block start -->
            <article class="instructor-block">
                <div class="container">
                    <div class="row mt-4 mb-5">
                        @foreach($instructors as $instructor)
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
                <!-- pagination start -->
                <div class="float-right">
                   {{ $instructors->links() }}
                </div>
                <!-- pagination end -->
            </article>
            <!-- instructor block end -->
            
        </div>
        
    <!-- content end -->
@endsection