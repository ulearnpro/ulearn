@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Settings</li>
  </ol>
  <h1 class="page-title">General</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{ route('admin.saveConfig') }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name="code" value="settingGeneral">
        <div class="row">
            <div class="form-group col-md-6">
              <label class="form-control-label">Application Name</label>
              <input type="text" class="form-control" name="application_name" 
                placeholder="Application Name" value="{{ isset($config['application_name']) ? $config['application_name'] : '' }}" />
            </div>
        
            <div class="form-group col-md-6">
              <label class="form-control-label">Meta Key</label>
              <input type="text" class="form-control" name="meta_key" 
                placeholder="Meta Key" value="{{ isset($config['meta_key']) ? $config['meta_key'] : '' }}" />
            </div>

            <div class="form-group col-md-12">
              <label class="form-control-label">Meta Description</label>
              <input type="text" class="form-control" name="meta_description" 
                placeholder="Meta Description" value="{{ isset($config['meta_description']) ? $config['meta_description'] : '' }}" />
            </div>

            <div class="form-group col-md-4">
              <label class="form-control-label">Header Logo</label>
              <div class="input-group input-group-file" data-plugin="inputGroupFile">
                <input type="text" class="form-control" id="header_logo_read" readonly="">
                <input type="hidden" name="old_header_logo" value="{{ isset($config['header_logo']) ? $config['header_logo'] : '' }}">
                <span class="input-group-btn">
                  <span class="btn btn-success btn-file">
                    <i class="icon wb-upload" aria-hidden="true"></i>
                    <input type="file" name="header_logo" class="item-img" id="header_logo">
                  </span>
                </span>
              </div>
              <div class="row">
                 <div class="col-md-6">
                  <span style="font-size: 10px;">
                    Extensions: jpg,jpeg,png 
                    <br>Dimesnion: 158px X 37px
                    <br> Max File Size: 1MB
                  </span>
                  </div>
                  @if(isset($config['header_logo']) && Storage::exists($config['header_logo']))
                  <div class="col-md-6 pl-0 mt-2">
                    <img src="{{ Storage::url($config['header_logo']) }}" width="158px" height="37px">
                  </div>
                  @endif
              </div>
            </div>
            

            <div class="form-group col-md-4">
              <label class="form-control-label">Footer Logo</label>
              <div class="input-group input-group-file" data-plugin="inputGroupFile">
                <input type="text" class="form-control" id="footer_logo_read" readonly="">
                <input type="hidden" name="old_footer_logo" value="{{ isset($config['footer_logo']) ? $config['footer_logo'] : '' }}">
                <span class="input-group-btn">
                  <span class="btn btn-success btn-file">
                    <i class="icon wb-upload" aria-hidden="true"></i>
                    <input type="file" name="footer_logo" class="item-img" id="footer_logo">
                  </span>
                </span>
              </div>
              <div class="row">
                 <div class="col-md-6">
                  <span style="font-size: 10px;">
                    Extensions: jpg,jpeg,png 
                    <br>Dimesnion: 263px X 60px
                    <br> Max File Size: 1MB
                  </span>
                  </div>
                  @if(isset($config['footer_logo']) && Storage::exists($config['footer_logo']))
                  <div class="col-md-6 pl-0 mt-2">
                    <img src="{{ Storage::url($config['footer_logo']) }}" width="158px" height="37px">
                  </div>
                  @endif
              </div>
            </div>

            <div class="form-group col-md-4">
              <label class="form-control-label">Fav Icon</label>
              <div class="input-group input-group-file" data-plugin="inputGroupFile">
                <input type="text" class="form-control" id="fav_icon_read" readonly="">
                <input type="hidden" name="old_fav_icon" value="{{ isset($config['fav_icon']) ? $config['fav_icon'] : '' }}">
                <span class="input-group-btn">
                  <span class="btn btn-success btn-file">
                    <i class="icon wb-upload" aria-hidden="true"></i>
                    <input type="file" name="fav_icon" class="item-img" id="fav_icon">
                  </span>
                </span>
              </div>
              <div class="row">
                 <div class="col-md-6">
                  <span style="font-size: 10px;">
                    Extensions: ico 
                    <br>Dimesnion: 16px X 16px
                    <br> Max File Size: 1MB
                  </span>
                  </div>
                  @if(isset($config['fav_icon']) && Storage::exists($config['fav_icon']))
                  <div class="col-md-6 pl-0 mt-2">
                    <img src="{{ Storage::url($config['fav_icon']) }}" width="16px" height="16px">
                  </div>
                  @endif
              </div>
            </div>

            <div class="form-group col-md-4">
              <label class="form-control-label">Admin Email</label>
              <input type="text" class="form-control" name="admin_email" 
                placeholder="Admin Email" value="{{ isset($config['admin_email']) ? $config['admin_email'] : '' }}" />
            </div>

            <div class="form-group col-md-4">
              <label class="form-control-label">Admin Commision</label>
              <input type="text" class="form-control" name="admin_commission" 
                placeholder="Admin Commision" value="{{ isset($config['admin_commission']) ? $config['admin_commission'] : '' }}" />
            </div>
        
            <div class="form-group col-md-4">
              <label class="form-control-label">Minimum Withdraw</label>
              <input type="text" class="form-control" name="minimum_withdraw" 
                placeholder="Minimum Withdraw" value="{{ isset($config['minimum_withdraw']) ? $config['minimum_withdraw'] : '' }}" />
            </div>

        </div>

      <hr>
      <div class="form-group row">
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-default btn-outline">Reset</button>
        </div>
      </div>
      
    </form>
  </div>
</div>

       
      <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function()
    { 
        tinymce.init({ 
          selector: "textarea",  // change this value according to your HTML
          plugins: "code",
          toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | code",
          menubar: false,
          height: 500,
          content_style: "#tinymce {color:#76838f;}"
        });

        
        $('.item-img').on('change', function () {
            readFile(this, $(this).attr('id')); 
        });

        function readFile(input, id) {    
            
            var file_name = input.files[0].name;
            var extension = (input.files[0].name).split('.').pop();
            if(id = 'fav_icon')
            {
                var allowed_extensions = ["ico"];
            }
            else
            {
                var allowed_extensions = ["jpg", "jpeg", "png"];
            }
             var allowed_extensions = ["jpg", "jpeg", "png"];
            var fsize = input.files[0].size;
            toastr.options.closeButton = true;
            toastr.options.timeOut = 5000;

            if (input.files && input.files[0]) {

                if ($.inArray(extension, allowed_extensions) == -1) {
                    toastr.error("Image format mismatch");
                    return false;
                } else if(fsize > 1048576) {
                    toastr.error("Image size exceeds");
                    return false;
                } 

                $('#'+id+'_read').attr('value', file_name);
            }
        }
    });
</script>

@endsection
