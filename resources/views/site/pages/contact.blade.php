@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>Contact</h1>
            </div>
        </div>
        <!-- banner end -->
        
        <!-- breadcrumb start -->
            <div class="breadcrumb-container">
                <div class="container">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                  </ol>
                </div>
            </div>
        
        <!-- breadcrumb end -->
        
        <div class="container">
            <div class="row ct-block">
                <div class="ct-block-col col-xl-3 offset-xl-1 col-lg-4 offset-lg-0 col-md-4 offset-md-0 col-sm-12 offset-sm-3 col-12 offset-3 my-2">
                    <div class="contact-icon">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <div class="contact-detail">
                        <span>GIVE US A CALL</span><br>
                        {{ Sitehelpers::get_option('pageContact', 'telephone') }}
                    </div>
                </div>
                <div class="ct-block-col col-xl-3 offset-xl-1 col-lg-4 offset-lg-0 col-md-4 offset-md-0 col-sm-12 offset-sm-3 col-12 offset-3 my-2">
                    <div class="contact-icon mr-3">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-detail">
                        <span>SEND US A MESSAGE</span><br>
                        {{ Sitehelpers::get_option('pageContact', 'email') }}
                    </div>
                </div>
                <div class="ct-block-col col-xl-3 offset-xl-1 col-lg-4 offset-lg-0 col-md-4 offset-md-0 col-sm-12 offset-sm-3 col-12 offset-3 my-2">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-detail">
                        <span>VISIT OUR LOCATION</span><br>
                        {{ Sitehelpers::get_option('pageContact', 'address') }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 vertical-align d-none d-lg-block map-block">
                    {!! Sitehelpers::get_option('pageContact', 'map') !!}
                </div>
                <div class="col-xl-6 offset-xl-0 col-lg-6 offset-lg-0 col-md-8 offset-md-2">
                    <div class="rightRegisterForm">
                            <div class="box-header">
                                Drop us a message
                            </div>
                            <div class="px-4 py-2">
                            <form class="form-horizontal" method="POST" action="{{ route('contact.admin') }}" id="contactForm">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>First Name</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="First Name" name="first_name">
                                        </div>
                                        <div class="col-6">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Last Name" name="last_name">
                                        </div>
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
            </div>
        </div>
@endsection


@section('javascript')
<script type="text/javascript">
$(document).ready(function()
{
    $("#contactForm").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
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
                first_name: {
                    required: 'This field is required.'
                },
                last_name: {
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