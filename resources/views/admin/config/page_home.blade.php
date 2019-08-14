@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pages</li>
  </ol>
  <h1 class="page-title">Home</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{ route('admin.saveConfig') }}">
      {{ csrf_field() }}
      <input type="hidden" name="code" value="pageHome">
       <div class="row">
            <div class="form-group col-md-6">
              <label class="form-control-label">Banner Title</label>
              <input type="text" class="form-control" name="banner_title" 
                placeholder="Banner Title" value="{{ isset($config['banner_title']) ? $config['banner_title'] : '' }}" />
            </div>
        
            <div class="form-group col-md-6">
              <label class="form-control-label">Banner Text</label>
              <input type="text" class="form-control" name="banner_text" 
                placeholder="Banner Text" value="{{ isset($config['banner_text']) ? $config['banner_text'] : '' }}" />
            </div>
        
            <div class="form-group col-md-6">
              <label class="form-control-label">Instructor Text</label>
              <input type="text" class="form-control" name="instructor_text" 
                placeholder="Instructor Text" value="{{ isset($config['instructor_text']) ? $config['instructor_text'] : '' }}" />
            </div>
        

            <div class="form-group col-md-6">
              <label class="form-control-label">Learn Block Title</label>
              <input type="text" class="form-control" name="learn_block_title" 
                placeholder="Learn Block Title" value="{{ isset($config['learn_block_title']) ? $config['learn_block_title'] : '' }}" />
            </div>

            <div class="form-group col-md-12">
                <label class="form-control-label">Learn Block Text</label>
                <textarea name="learn_block_text">{{ isset($config['learn_block_text']) ? $config['learn_block_text'] : '' }}</textarea>
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
            selector:'textarea',
            menubar:false,
            statusbar: false,
            height: 280,
            content_style: "#tinymce p{color:#76838f;}"
        });
    });
</script>

@endsection