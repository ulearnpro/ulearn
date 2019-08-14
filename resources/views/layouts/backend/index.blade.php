<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <meta name="_token" content="{!! csrf_token() !!}"/>

  <title>ULEARN</title>

  <link rel="apple-touch-icon" href="{{ asset('backend/assets/images/apple-touch-icon.png') }}">
  <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico ') }}">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min599c.css?v4.0.2') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-extend.min599c.css?v4.0.2') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/site.min599c.css?v4.0.2') }}">

  

  <!-- Plugins -->
  <link rel="stylesheet" href="{{ asset('backend/vendor/asscrollable/asScrollable.min599c.css?v4.0.2') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendor/flag-icon-css/flag-icon.min599c.css?v4.0.2') }}">

  <link rel="stylesheet" href="{{ asset('backend/vendor/toastr/toastr.min599c.css?v4.0.2') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendor/alertify/alertify.min599c.css?v4.0.2') }}">

  <link rel="stylesheet" href="{{ asset('backend/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min599c.css?v4.0.2') }}">

  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('backend/fonts/web-icons/web-icons.min599c.css?v4.0.2') }}">
  <link rel="stylesheet" href="{{ asset('backend/fonts/font-awesome/font-awesome.css?v4.0.2') }}">
  

  <link rel="stylesheet" href="{{ asset('backend/vendor/datatables.net-bs4/dataTables.bootstrap4.min599c.css?v4.0.2') }}">

  <link rel="stylesheet" href="{{ asset('backend/vendor/croppie/croppie.css?v4.0.2') }}">
  
  <!-- Scripts -->
  <script src="{{ asset('backend/vendor/breakpoints/breakpoints.min599c.js?v4.0.2') }}"></script>
  
  <script>
    Breakpoints();
  </script>
</head>
<body>
  <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega navbar-expand-md"
    role="navigation">

    <div class="navbar-header">
      <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
        data-toggle="menubar">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
        data-toggle="collapse">
        <i class="icon wb-more-horizontal" aria-hidden="true"></i>
      </button>
      <div class="navbar-brand navbar-brand-center">
        <img class="navbar-brand-logo" src="{{ asset('backend/assets/images/b_logo.png') }}" title="ULEARN">
        <span class="navbar-brand-text hidden-xs-down"> ULEARN</span>
      </div>
      <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
        data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon wb-search" aria-hidden="true"></i>
      </button>
    </div>

    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        
        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
          <li class="nav-item dropdown">
            <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
              data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                <img src="{{ asset('backend/assets/images/user.png') }}" alt="...">
                <i></i>
              </span>
            </a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" href="{{ url('/') }}" role="menuitem"><i class="icon fas fa-home" aria-hidden="true"></i> Home Page</a>
              <div class="dropdown-divider" role="presentation"></div>
              <a class="dropdown-item" href="{{ route('logOut') }}" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
            </div>
          </li>
          
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->

      <!-- Site Navbar Seach -->
      <div class="collapse navbar-search-overlap" id="site-navbar-search">
        <form role="search">
          <div class="form-group">
            <div class="input-search">
              <i class="input-search-icon wb-search" aria-hidden="true"></i>
              <input type="text" class="form-control" name="site-search" placeholder="Search...">
              <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"
                data-toggle="collapse" aria-label="Close"></button>
            </div>
          </div>
        </form>
      </div>
      <!-- End Site Navbar Seach -->
    </div>
  </nav>
  <div class="site-menubar">

    @if(Auth::user()->hasRole('admin'))
        @include('layouts/backend/admin_sidebar')
    @elseif(Auth::user()->hasRole('instructor'))
        @include('layouts/backend/instructor_sidebar')
    @endif
  </div>
  

  <!-- Page -->
  <div class="page">
    @yield('content')
  </div>
  <!-- End Page -->


  <!-- Footer -->
  <footer class="site-footer">
    <div class="site-footer-legal">© {{ date('Y') }} <a href="javascript:void(0)">ULEARN</a></div>
  </footer>
  <!-- Core  -->
  <script src="{{ asset('backend/vendor/babel-external-helpers/babel-external-helpers599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/vendor/jquery/jquery.min599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/vendor/jquery-ui/jquery-ui.min599c.js') }}"></script>
  <script src="{{ asset('backend/vendor/popper-js/umd/popper.min599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/vendor/bootstrap/bootstrap.min599c.js?v4.0.2') }}"></script>
  
  <!-- Animation and Scroll -->
  
  <script src="{{ asset('backend/vendor/asscrollbar/jquery-asScrollbar.min599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/vendor/asscrollable/jquery-asScrollable.min599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/vendor/ashoverscroll/jquery-asHoverScroll.min599c.js?v4.0.2') }}"></script>

  
  <!-- Scripts -->
  <script src="{{ asset('backend/js/Component.min599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/js/Plugin.min599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/js/Base.min599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/js/Config.min599c.js?v4.0.2') }}"></script>

  <!-- Menu bar -->
  <script src="{{ asset('backend/assets/js/Section/Menubar.min599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/assets/js/Section/Sidebar.min599c.js?v4.0.2') }}"></script>

  <script src="{{ asset('backend/assets/js/Plugin/menu.min599c.js?v4.0.2') }}"></script>
  
  
  <!-- Page -->
  <script src="{{ asset('backend/assets/js/Site.min599c.js?v4.0.2') }}"></script>

  <!-- Alertify -->
  <script src="{{ asset('backend/vendor/alertify/alertify599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/js/Plugin/alertify.min599c.js?v4.0.2') }}"></script>
  
  <!-- Toastr -->
  <script src="{{ asset('backend/vendor/toastr/toastr.min599c.js?v4.0.2') }}"></script>
  
  <!-- Datatable -->
  <script src="{{ asset('backend/vendor/datatables.net/jquery.dataTables599c.js?v4.0.2') }}"></script>
  <script src="{{ asset('backend/vendor/datatables.net-bs4/dataTables.bootstrap4599c.js?v4.0.2') }}"></script>
  
  <!-- TagsInput -->
  <script src="{{ asset('backend/js/Plugin/bootstrap-tagsinput.min599c.js?v4.0.2') }}"></script>

  <!-- Croppie -->
  <script src="{{ asset('backend/vendor/croppie/croppie.min.js?v4.0.2') }}"></script>

  <!-- jquery validation --> 
  <script src="{{ asset('backend/js/Plugin/jquery.validate.js') }}"></script>

  <!-- jquery form --> 
  <script src="{{ asset('backend/vendor/jquery-form/jquery.form.js?v4.0.2') }}"></script>

  <script src="{{ asset('backend/vendor/tinymce/tinymce.min.js?v4.0.2') }}"></script>

  
   <script>
   $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    (function(document, window, $) {
      'use strict';

      var Site = window.Site;
      $(document).ready(function() {
        Site.run();


        //override defaults for alertify
        alertify.theme('bootstrap');

        $('.delete-record').click(function(event)
        {
            var url = $(this).attr('href');
            event.preventDefault();
            alertify.confirm('Are you sure want to delete this record?', function () {
                window.location.href = url;
            }, function () {    
                return false;
            });
        });

        /* Toastr messages */
        toastr.options.closeButton = true;
        toastr.options.timeOut = 5000;
        @if(session()->has('success'))
         toastr.success("{{ session('success') }}");
        @endif
        @if(session()->has('error'))
         toastr.error("{{ session('error') }}");
        @endif
        @if(session()->has('info'))
         toastr.info("{{ session('info') }}");
        @endif
      });
    })(document, window, jQuery);
  </script>
  @yield('javascript')
</body>
</html>