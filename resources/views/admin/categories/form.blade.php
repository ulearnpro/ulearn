@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.categories') }}">Categories</a></li>
    <li class="breadcrumb-item active">Add</li>
  </ol>
  <h1 class="page-title">Add Category</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{ route('admin.saveCategory') }}" id="categoryForm">
      {{ csrf_field() }}
      <input type="hidden" name="category_id" value="{{ $category->id }}">
      <div class="row">
      
        <div class="form-group col-md-4">
          <label class="form-control-label">Category Name <span class="required">*</span></label>
          <input type="text" class="form-control" name="name" 
            placeholder="First Name" value="{{ $category->name }}" />
            @if ($errors->has('name'))
                <label class="error" for="name">{{ $errors->first('name') }}</label>
            @endif
        </div>

        <div class="form-group col-md-4">
          <label class="form-control-label">Icon Class <span class="required">*</span></label>
          <input type="text" class="form-control" name="icon_class" 
            placeholder="Icon Class" value="{{ $category->icon_class }}" />
            @if ($errors->has('icon_class'))
                <label class="error" for="name">{{ $errors->first('icon_class') }}</label>
            @endif
          <span>Example:fa-user | Use <a href="https://fontawesome.com/icons?d=gallery" target="_blank">Font Awesome</a> icons</span>
        </div>
      
        
      <div class="form-group col-md-4">
        <label class="form-control-label">Status</label>
        <div>
          <div class="radio-custom radio-default radio-inline">
            <input type="radio" id="inputBasicActive" name="is_active" value="1" @if($category->is_active) checked @endif />
            <label for="inputBasicActive">Active</label>
          </div>
          <div class="radio-custom radio-default radio-inline">
            <input type="radio" id="inputBasicInactive" name="is_active" value="0" @if(!$category->is_active) checked @endif/>
            <label for="inputBasicInactive">Inactive</label>
          </div>
        </div>
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
        $("#categoryForm").validate({
            rules: {
                name: {
                    required: true
                },
                icon_class: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: 'The category name field is required.'
                },
                icon_class: {
                    required: 'The icon class field is required.'
                }
            }
        });
    });
</script>
@endsection