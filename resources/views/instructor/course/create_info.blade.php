@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('instructor.course.list') }}">Courses</a></li>
    <li class="breadcrumb-item active">Add</li>
  </ol>
  <h1 class="page-title">Add Course</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">

    
    @include('instructor/course/tabs')
    

    <form method="POST" action="{{ route('instructor.course.info.save') }}" id="courseForm">
      {{ csrf_field() }}
      <input type="hidden" name="course_id" value="{{ $course->id }}">
      <div class="row">
      
        <div class="form-group col-md-4">
            <label class="form-control-label">Course Title <span class="required">*</span></label>
            <input type="text" class="form-control" name="course_title" 
                placeholder="Course Title" value="{{ $course->course_title }}" />
                @if ($errors->has('course_title'))
                    <label class="error" for="course_title">{{ $errors->first('course_title') }}</label>
                @endif
        </div>

        <div class="form-group col-md-4">
            <label class="form-control-label">Category <span class="required">*</span></label>
            <select class="form-control" name="category_id">
                <option value="">Select</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                    @if($category->id == $course->category_id){{ 'selected' }}@endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            
            @if ($errors->has('category_id'))
                <label class="error" for="category_id">{{ $errors->first('category_id') }}</label>
            @endif
        </div>

        <div class="form-group col-md-4">
            <label class="form-control-label">Instruction Level <span class="required">*</span></label>
            <select class="form-control" name="instruction_level_id">
                <option value="">Select</option>
                @foreach($instruction_levels as $instruction_level)
                    <option value="{{ $instruction_level->id }}" 
                    @if($instruction_level->id == $course->instruction_level_id){{ 'selected' }}@endif>
                        {{ $instruction_level->level }}
                    </option>
                @endforeach
            </select>
            
            @if ($errors->has('instruction_level_id'))
                <label class="error" for="instruction_level_id">{{ $errors->first('instruction_level_id') }}</label>
            @endif
        </div>

        <div class="form-group col-md-4">
            <label class="form-control-label">Duration</label>
            <input type="text" class="form-control" name="duration" 
                placeholder="Course Duration" value="{{ $course->duration }}" />
        </div>

        <div class="form-group col-md-8">
            <label class="form-control-label">Keywords</label>
            <input type="text" class="form-control tagsinput" name="keywords" 
                placeholder="Keywords" value="{{ $course->keywords }}" />
        </div>

        <div class="form-group col-md-4">
            <label class="form-control-label">Price <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="Leave blank if the course is free"></i></label>
            <input type="number" class="form-control" name="price" 
                placeholder="Course Price" value="{{ $course->price }}" />
        </div>

        <div class="form-group col-md-4">
            <label class="form-control-label">Strike Out Price <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="Applied only for paid courses"></i></label>
            <input type="text" class="form-control" name="strike_out_price" 
                placeholder="Strike Out Price" value="{{ $course->strike_out_price }}" />
        </div>

        <div class="form-group col-md-4">
            <label class="form-control-label">Status</label>
            <div>
              <div class="radio-custom radio-default radio-inline">
                <input type="radio" id="inputBasicActive" name="is_active" value="1" @if($course->is_active) checked @endif />
                <label for="inputBasicActive">Active</label>
              </div>
              <div class="radio-custom radio-default radio-inline">
                <input type="radio" id="inputBasicInactive" name="is_active" value="0" @if(!$course->is_active) checked @endif/>
                <label for="inputBasicInactive">Inactive</label>
              </div>
            </div>
        </div>





        <div class="form-group col-md-12">
            <label class="form-control-label">Overview</label>
            <textarea name="overview">
                {{ $course->overview }}
            </textarea>
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
            content_style: "#tinymce p{color:#76838f;}"
        });

        $(".tagsinput").tagsinput();

        $("#courseForm").validate({
            rules: {
                course_title: {
                    required: true
                },
                category_id: {
                    required: true
                },
                instruction_level_id: {
                    required: true
                }
            },
            messages: {
                course_title: {
                    required: 'The course title field is required.'
                },
                category_id: {
                    required: 'The category field is required.'
                },
                instruction_level_id: {
                    required: 'The instruction level field is required.'
                }
            }
        });

        $('.course-id-empty').click(function()
        {
            toastr.error("Fill course info to proceed");
        });
    });
</script>
@endsection