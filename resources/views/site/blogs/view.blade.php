@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>Blog</h1>
            </div>
        </div>
        <!-- banner end -->
        
        <!-- breadcrumb start -->
            <div class="breadcrumb-container">
                <div class="container">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blogs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $blog->blog_title }}</li>
                  </ol>
                </div>
            </div>
        
        <!-- breadcrumb end -->
        
        <div class="container">
            <div class="row mt-4">
                <!-- blog main start -->
                <div class="col-xl-9 col-lg-9 col-md-8">
                    
                        <div class="cv-course-container">
                            <h5>{{ $blog->blog_title }}</h5>
                            
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4 col-12">
                                    <div class="instructor-clist m-0 pt-1">
                                        <div>
                                            <i class="fas fa-edit"></i>&nbsp;
                                            <span><i class="d-md-none d-sm-none d-lg-inline-block">Posted on</i> <b>{{ $blog->created_at->diffForHumans() }}</b></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-12">
                                    <div class="float-sm-right">
                                        <button type="button" class="btn btn-sm social-btn-sm facebook-btn">
                                                    <i class="fab fa-facebook-f"></i>&nbsp;&nbsp;
                                                    <span>Share</span>
                                        </button>
                                        <button type="button" class="btn btn-sm social-btn-sm twitter-btn">
                                                    <i class="fab fa-twitter"></i>&nbsp;&nbsp;
                                                    <span>Tweet</span>
                                        </button>
                                        <button type="button" class="btn btn-sm social-btn-sm google-btn">
                                                    <i class="fab fa-pinterest"></i>&nbsp;&nbsp;
                                                    <span>Tweet</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="course-image my-3">
                                <img src="@if(Storage::exists($blog->blog_image)){{ Storage::url($blog->blog_image) }}@else{{ asset('backend/assets/images/blog_image.jpeg') }}@endif">
                            </div>

                            <p>{!! $blog->description !!}</p>
                            
                            <hr class="mb-5 mt-4">
                        </div>
                        
                </div>
                <!-- blog main end -->

                <!-- blog sidebar start -->
                <div class="col-xl-3 col-lg-3 col-md-4 d-none d-md-block">
                    <section class="course-feature">
                        <h6 class="text-center mt-3">SUBSCRIBE TO ULEARN BLOG</h6>

                        <div class="pl-3 pr-2">
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusant doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt.</p>

                            <input type="text" class="form-control form-control-sm" placeholder="abc@xyz.com">

                            <a href="#" class="btn btn-ulearn-cview mt-3">Subscribe</a>
                        </div>
                    </section>
                    
                    <h6 class="mt-4 underline-heading">BLOG ARCHIVES</h6>
                    <ul class="ul-no-padding">
                        @foreach ($archieves as $archieve)
                        <li class="my-2"> 
                            {{ $archieve->month_name.' '.$archieve->year.' ('.$archieve->blog_count.')' }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <!-- blog sidebar end -->
            </div>
        </div>
        
    <!-- content end -->
@endsection

@section('javascript')
<script type="text/javascript">

</script>
@endsection