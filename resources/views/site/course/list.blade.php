@extends('layouts.frontend.index')
@section('content')
<?php 
    $get = '';
    $link = Request::url();
    $i = $j = 0;
    // echo '<pre>';print_r($_GET);
    foreach ($_GET as $key => $value):
      if($key != 'sort_price' && $key != 'sort_rating')
      {
        if(is_array($value))
        {
            foreach ($value as $inner_value):
                $get .= ($i == 0) ? '?'.$key.'[]='.$inner_value : '&'.$key.'[]='.$inner_value;
            $i++;
            endforeach;
        }
        else
        {
            $get .= ($i == 0) ? '?'.$key.'='.$value : '&'.$key.'='.$value;    
        }
        
      }
        if(is_array($value))
        {
            foreach ($value as $inner_value):
                $link .= ($j == 0) ? '?'.$key.'[]='.$inner_value : '&'.$key.'[]='.$inner_value;
            $j++;
            endforeach;
        }
        else
        {
            $link .= ($j == 0) ? '?'.$key.'='.$value : '&'.$key.'='.$value;   
        }
      
    $i++;
    $j++;
    endforeach;
?>
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>Course List</h1>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
            <div class="breadcrumb-container">
                <div class="container">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Course List</li>
                  </ol>
                </div>
            </div>
        
        <!-- breadcrumb end -->
        <div class="container mt-5">
            <div class="row">
                <!-- filter start -->
                <div class="col-xl-2 col-lg-2 col-md-3 d-none d-md-block">
                <form method="GET" action="{{ route('course.list') }}" id="courseList">
                    <span class="blue-title">Filter Results</span>
                    @if($_GET)
                    <a href="{{ route('course.list') }}" class="clear-filters"><i class="fa fa-sync"></i>&nbsp;Clear filters</a>
                    @endif
                    <h6 class="mt-2 underline-heading">Categories</h6>
                    <ul class="ul-no-padding">
                        @foreach ($categories as $category)
                        <li> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input filter-results" id="{{ 'cat-'.$category->id }}" name="category_id[]" value="{{ $category->id }}" 
                                @if(isset($_GET['category_id']))
                                    {{ in_array($category->id, $_GET['category_id']) ? 'checked' : '' }}
                                @endif
                                 >
                                <label class="custom-control-label" for="{{ 'cat-'.$category->id }}">{{ $category->name }}</label>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <h6 class="mt-3 underline-heading">Level</h6>
                    
                    <ul class="ul-no-padding">
                        @foreach ($instruction_levels as $instruction_level)
                        <li> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input filter-results" id="{{ 'ins-level-'.$instruction_level->id }}" name="instruction_level_id[]" value="{{ $instruction_level->id }}"
                                @if(isset($_GET['instruction_level_id']))
                                    {{ in_array($instruction_level->id, $_GET['instruction_level_id']) ? 'checked' : '' }}
                                @endif
                                >
                                <label class="custom-control-label" for="{{ 'ins-level-'.$instruction_level->id }}">{{ $instruction_level->level }}</label>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <h6 class="mt-3 underline-heading">Price</h6>
                    <?php $levels = array(
                                            '0-0' => 'Free',
                                            '1-50' => 'Less than USD 50',
                                            '50-99' => 'USD 50 - USD 99',
                                            '100-199' => 'USD 100 - USD 199',
                                            '200-299' => 'USD 200 - USD 299',
                                            '300-399' => 'USD 300 - USD 399',
                                            '400-499' => 'USD 400 - USD 499',
                                            '500' => 'More than USD 500',
                                            );
                    ?>
                    <ul class="ul-no-padding">
                        <?php foreach ($levels as $l_key => $l_value) { ?>
                        <li> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input filter-results" id="{{ $l_key }}" name="price_id[]" value="{{ $l_key }}"
                                @if(isset($_GET['price_id']))
                                    {{ in_array($l_key, $_GET['price_id']) ? 'checked' : '' }}
                                @endif
                                >
                                <label class="custom-control-label" for="{{ $l_key }}">{{ $l_value }}</label>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                </form>
                </div>
                <!-- filter end -->
                <!-- course block start -->
                <div class="col-xl-10 col-lg-10 col-md-9">
                    <div class="row px-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-8">
                            <span >Showing {{ $courses->currentPage() }} of {{ $courses->lastPage() }} page(s)</span>
                        </div>
                        <div class="col-xl-2 offset-xl-4 col-lg-2 offset-lg-4 col-md-3 offset-md-3 col-sm-3 offset-sm-3 col-4">
                            <select class="form-control form-control-sm sort-by">
                                <option value="">Sort By</option>
                                <option<?php echo(!empty($_GET['sort_price']) && $_GET['sort_price']=='asc')?' selected="selected"':'';?> value="sort_price=asc">Price (Low to High)</option>
                                <option<?php echo(!empty($_GET['sort_price']) && $_GET['sort_price']=='desc')?' selected="selected"':'';?>  value="sort_price=desc">Price (High to Low)</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- course start -->
                    <div class="row">
                    @foreach($courses as $course)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                            <div class="course-block mx-auto">
                            <a href="{{ route('course.view', $course->course_slug) }}" class="c-view">
                                <main>
                                    <img src="@if(Storage::exists($course->thumb_image)){{ Storage::url($course->thumb_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif">
                                    <div class="col-md-12"><h6 class="course-title">{{ $course->course_title }}</h6></div>
                                    
                                    <div class="instructor-clist">
                                        <div class="col-md-12">
                                            <i class="fa fa-chalkboard-teacher"></i>&nbsp;
                                            <span>Created by <b>{{ $course->first_name.' '.$course->last_name }}</b></span>
                                        </div>
                                    </div>
                                </main>
                                <footer>
                                    <div class="c-row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            @php $course_price = $course->price ? config('config.default_currency').$course->price : 'Free'; @endphp
                                            <h5 class="course-price">{{  $course_price }}&nbsp;<s>{{ $course->strike_out_price ? $course->strike_out_price : '' }}</s></h5>
                                        </div>
                                        <div class="col-md-5 offset-md-1 col-sm-5 offset-sm-1 col-5 offset-1">
                                            <star class="course-rating">
                                            <?php for ($r=1;$r<=5;$r++) { ?>
                                                <span class="fa fa-star <?php echo $r <= $course->average_rating ? 'checked' : '';?>"></span>
                                            <?php }?>
                                            </star>
                                        </div>
                                    </div>
                                </footer>
                            </a>    
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <!-- course end -->
                    <!-- pagination start -->
                    <div class="row float-right mt-5">
                       {{ $courses->appends($_GET)->links() }}
                    </div>
                    <!-- pagination end -->
                </div>
                <!-- course block end -->
            </div>
        </div>
        
    <!-- content end -->
@endsection

@section('javascript')
<script type="text/javascript">


$(document).ready(function()
{
    $('.filter-results').change(function()
    {
        $('#courseList').submit();
    });

    $('.sort-by').change(function()
    {
        var search = '{{ url("courses") }}';
        var get = '<?php echo $get;?>';
        var sort = $(this).val();
        var operand = '<?php echo empty($get) ? "?" : "&";?>';
        window.location = search + get + operand + sort;
    });

    $('.c-view').click(function()
    {
         var link = '{{ $link }}';
         var page_link = $(this).attr('href');
         $.ajax({
                type:  'get',
                cache:  false ,
                url:  '{{ route("course.breadcurmb") }}',
                data:  {link:link},
                success: function(data)
                {
                    window.location = page_link;
                }
            });
         return false;
    });
});
</script>
@endsection