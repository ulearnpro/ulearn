@extends('layouts.frontend.index')
@section('content')
 <!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>Checkout</h1>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
            <div class="breadcrumb-container">
                <div class="container">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="@if($course_breadcrumb) {{ $course_breadcrumb }} @else {{ route('course.list') }} @endif">Course List</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course.view', $course->course_slug) }}">Course</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                  </ol>
                </div>
            </div>
        
        <!-- breadcrumb end -->
        
        
        <article class="container mt-4">
            <div class="row">
               <div class="col-xl-7 offset-xl-3 col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <h6 class="underline-heading mb-4">Confirm Purchase</h6>
                    
                    
                    <div class="row mb-1">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-4">
                            <img src="@if(Storage::exists($course->thumb_image)){{ Storage::url($course->thumb_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif" width="120" height="90">
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-8">
                            <h6 class="mb-xl-0">{{ $course->course_title }}</h6>
                            <div class="instructor-clist mb-0 mt-1 d-sm-block d-none">
                                <div class="ml-1">
                                    <i class="far fa-bookmark"></i>&nbsp;&nbsp;
                                    <span>Category <b>{{ $course->category->name }}</b></span>
                                </div>
                            </div>
                            <div class="instructor-clist mb-0 mt-1">
                                <div>
                                    <i class="fa fa-chalkboard-teacher"></i>&nbsp;
                                    <span>Created by <b>{{ $course->instructor->first_name.' '.$course->instructor->last_name }}</b></span>
                                </div>
                            </div>
                            @php $course_price = $course->price == 0.00 ? 'Free' : config('config.default_currency').$course->price; @endphp
                            <h6 class="c-price-checkout">{{  $course_price }}&nbsp;<s>{{ $course->strike_out_price ? $course->strike_out_price : '' }}</s></h6>
                        </div>

                    </div>
                    
                    <div class="col-xl-7 offset-xl-2 col-lg-8 offset-lg-2 col-md-9 offset-md-2 col-sm-9 offset-sm-2 col-11 offset-1">
                    <form method="POST" action="{{ route('payment.form') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="payment_method" value="paypal_express_checkout">
                    <input type="hidden" name="course_title" value="{{ $course->course_title }}">

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-lg btn-block social-btn facebook-btn">
                            <div class="row">
                                <div class="col-3">
                                    <i class="@if($course->price == 0.00) fas fa-cart-arrow-down @else fab fa-paypal  @endif float-right"></i>
                                </div>
                                <div class="col-9">
                                    <span>
                                    @if($course->price == 0.00)
                                    Subscribe to the course
                                    @else
                                    Pay with Paypal Account
                                    @endif
                                    </span>
                                </div>
                            </div>
                        </button>
                    </div>
                    </form>
                    </div>
               </div>
               <!-- <div class="col-xl-6 col-lg-6 col-md-12">
                   <h4 class="c-price-total ml-4">$1280&nbsp;<span><s>$43,200</s>&nbsp;94% off</span></h4>
                   <div class="rightRegisterForm mt-3">
                        <div class="box-header">
                            Make Payment
                        </div>
                        <div class="px-4 py-2">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Card Number">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                        <label>MM</label>
                                        <select class="form-control form-control-sm">
                                            <option>MM</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label>YYYY</label>
                                        <select class="form-control form-control-sm">
                                            <option>YYYY</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label>CVV</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="CVV">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    <label>Name on Card</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Name on Card">
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="button" class="btn btn-lg btn-block login-page-button">Complete Payment</button>
                            </div>

                            <div class="hr-container">
                               <hr class="hr-inline" align="left">
                               <span class="hr-text"> or </span>
                               <hr class="hr-inline" align="right">
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-lg btn-block social-btn facebook-btn">
                                    <div class="row">
                                        <div class="col-3">
                                            <i class="fab fa-paypal float-right"></i>
                                        </div>
                                        <div class="col-9">
                                            <span>
                                            Pay with Paypal Account
                                            </span>
                                        </div>
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>
               </div> -->
            </div>

           
                    
        </article>
        
        
    <!-- content end -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function()
{
    initFancybox();
});
</script>
@endsection