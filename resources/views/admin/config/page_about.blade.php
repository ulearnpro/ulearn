@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pages</li>
  </ol>
  <h1 class="page-title">About</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{ route('admin.saveConfig') }}">
      {{ csrf_field() }}
      <input type="hidden" name="code" value="pageAbout">
        <div class="row">
            <div class="form-group col-md-12">
                <label class="form-control-label">Content</label>
                <textarea name="content">{{ isset($config['content']) ? $config['content'] : '' }}</textarea>
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
          content_style: "#tinymce {color:#76838f;}",
          extended_valid_elements: 'i[class]'
        });
    });
</script>

@endsection
