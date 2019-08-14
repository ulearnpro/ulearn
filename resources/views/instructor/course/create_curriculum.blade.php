@extends('layouts.backend.index')
@section('content')

@php
use App\Library\ulearnHelpers;
$course_id = $course->id;
@endphp
<link href="{{ asset('backend/curriculum/css/createcourse/style.css') }}" rel="stylesheet">

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
    
    <!-- curriculum start -->
    <div class="curriculam-block">
<div class="container">
  <div class="row">  
    
    
    <div class="col-md-12">

      <div class="lach_dev resp-tab-content course_tab"> 
        <div class="slider_divsblocks">
          
          <div class="form-group">
            <form method="POST" action="{{ 'course/updatecourse' }}" accept-charset="UTF-8" class="form-horizontal saveLabel" parsley-validate="" novalidate=" " enctype="multipart/form-data">
            
             <input name="course_id" type="hidden" value="{{ $course->id }}">


            <input name="coursesection" type="hidden" value="{{ url('courses/section/save') }}">
            <input name="courselecture" type="hidden" value="{{ url('courses/lecture/save') }}">
            <input name="coursequiz" type="hidden" value="{{ url('courses/quiz/save') }}">
            <input name="coursecurriculumsort" type="hidden" value="{{ url('courses/curriculum/sort') }}">
            <input name="coursecurriculumquizquestionsort" type="hidden" value="{{ url('courses/curriculum/sortquiz') }}">
            <input name="coursesectiondel" type="hidden" value="{{ url('courses/section/delete') }}">
            <input name="courselecturequizdel" type="hidden" value="{{ url('courses/lecturequiz/delete') }}">
            <input name="courselecturedesc" type="hidden" value="{{ url('courses/lecturedesc/save') }}">
            <input name="courselecturepublish" type="hidden" value="{{ url('courses/lecturepublish/save') }}">
            <input name="courselecturevideo" type="hidden" value="{{ url('courses/lecturevideo/save') }}">
            <input name="courselecturetext" type="hidden" value="{{ url('courses/lecturetext/save') }}">
            <input name="courselectureres" type="hidden" value="{{ url('courses/lectureres/delete') }}">
            <input name="courseselectlibrary" type="hidden" value="{{ url('courses/lecturelib/save') }}">
            <input name="courseselectlibraryres" type="hidden" value="{{ url('courses/lecturelibres/save') }}">
            <input name="courseexternalres" type="hidden" value="{{ url('courses/lectureexres/save') }}">
            
            
            
            
            <div class="su_course_curriculam">

              <div class="su_course_curriculam_sortable">
                <ul class="clearfix ui-sortable">
                  @php $sectioncount = '1'; $lecturecount = '1'; $quizcount = '1'; @endphp
                  @foreach($sections as $section)

                  <li class="su_gray_curr parentli section-{!! $section->section_id !!}">
                    <div class="row-fluid sorthandle">
                      <div class="col col-lg-12">
                        <div class="su_course_section_label su_gray_curr_block">
                          <div class="edit_option edit_option_section">{!! Lang::get('curriculum.section')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle">{!! $section->title !!}</label>
                            <input type="text" maxlength="80" class="chcountfield su_course_update_section_textbox" @if($section->title == 'Start Here') placeholder="Start Here" value="" @else value="{!! $section->title !!}" @endif>
                            <span class="ch-count">@if($section->title == 'Start Here') 80 @else{!! 80-strlen($section->title) !!}@endif</span>
                          </div>
                          <input type="hidden" value="{!! $section->section_id !!}" class="sectionid" name="sectionids[]">
                          <input type="hidden" value="{!! $section->sort_order !!}" class="sectionpos" name="sectionposition[]">
                          <div class="deletesection" onclick="deletesection({!! $section->section_id !!})"></div>
                          <div class="updatesection" onclick="updatesection({!! $section->section_id !!})"></div>
                        </div>
                      </div>
                    </div>
                  </li>

                  @if(isset($lecturesquiz[$section->section_id]))
                  @foreach($lecturesquiz[$section->section_id] as $lecturequiz)
                  @if($lecturequiz->type == 0)
                  <li class="lq_sort su_lgray_curr childli lecture-{!! $lecturequiz->lecture_quiz_id !!} lecture parent-s-{!! $section->section_id !!}">
                    <div class="row-fluid sorthandle">
                      <div class="col col-lg-12">
                        <div class="su_course_lecture_label @if(!is_null($lecturequiz->media_type) && $lecturequiz->publish == 0) su_orange_curr_block @elseif(!is_null($lecturequiz->media_type) && $lecturequiz->publish == 1) su_green_curr_block @else su_lgray_curr_block @endif">
                          <div class="edit_option edit_option_lecture">{!! Lang::get('curriculum.Lecture')!!} <span class="serialno">{!! $lecturecount !!}</span>: <label class="slqtitle">{!! $lecturequiz->title !!}</label>
                            <input type="text" class="su_course_update_lecture_textbox chcountfield" value="{!! $lecturequiz->title !!}" maxlength="80">
                            <span class="ch-count">{!! 80-strlen($lecturequiz->title) !!}</span>
                          </div>
                          <input type="hidden" value="{!! $lecturequiz->lecture_quiz_id !!}" class="lectureid" name="lectureids[]">
                          <input type="hidden" value="{!! $lecturequiz->sort_order !!}" class="lecturepos" name="lectureposition[]">
                          <input type="hidden" value="{!! $section->section_id !!}" class="lecturesectionid" name="lecturesectionid">
                          <div class="deletelecture" onclick="deletelecture({!! $lecturequiz->lecture_quiz_id !!},{!! $section->section_id !!})"></div>
                          <div class="updatelecture" onclick="updatelecture({!! $lecturequiz->lecture_quiz_id !!},{!! $section->section_id !!})"></div>
                          <div class="lecture_add_content" id="lecture_add_content{!! $lecturequiz->lecture_quiz_id !!}">
                            @if(empty($lecturequiz->description))
                            <input type="button" name="lecture_add_content" class="adddescription" value="{!! Lang::get('curriculum.Add_Description')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                            @endif
                            @if(empty($lecturequiz->media) && is_null($lecturequiz->media_type))
                            <input type="button" name="lecture_add_content" value="{!! Lang::get('curriculum.Add_Content')!!}" class="addcontents" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                            @endif
                            <div class="closeheader">
                              <span class="closetext"></span>
                              <input type="button" name="lecture_close_content" value="X" class="btn-danger closecontents closebtn" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    
                    <!-- add contents block start -->
                    <div class="lecturepopup hideit" id="wholeblock-{!! $lecturequiz->lecture_quiz_id !!}">
                      <div class="lecturecontent">
                        <div class="lecture-media">
                          <div class="clearfix">
                            <div class="divli lmedia-video" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"  alt="video"><div class="lecturemedia"><span>{!! Lang::get('curriculum.Video')!!}</span></div><label>{!! Lang::get('curriculum.Video')!!}</label><div class="innershadow"></div></div>
                            <div class="divli lmedia-audio" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" alt="audio"><div class="lecturemedia"><span>{!! Lang::get('curriculum.Audio')!!}</span></div><label>{!! Lang::get('curriculum.Audio')!!}</label><div class="innershadow"></div></div>
                            <div class="divli lmedia-file" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" alt="file"><div class="lecturemedia"><span>{!! Lang::get('curriculum.Document')!!}</span></div><label>{!! Lang::get('curriculum.Document')!!}</label><div class="innershadow"></div></div>
                            <div class="divli lmedia-text" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" alt="text"><div class="lecturemedia"><span>{!! Lang::get('curriculum.Text')!!}</span></div><label>{!! Lang::get('curriculum.Text')!!}</label><div class="innershadow"></div></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Add contents block end -->
                    

                    <!-- add video start -->
                    <div class="lecturepopup @if(empty($lecturequiz->media)) @if($lecturequiz->media_type != 3) hideit @endif @endif" id="contentpopshow{!! $lecturequiz->lecture_quiz_id !!}">
                      <div class="lecturecontent_inner ltwovideo">
                        <div class="lecturecontent_video lecturecontent_tab">
                          <div class="lecturecontent_video_content lecturecontent_tab_content">
                            <div id="uploadvideo{!! $lecturequiz->lecture_quiz_id !!}" class="uploadvideo" style="display: block;">
                            
                              <div class="cccontainer" id="cccontainer{!! $lecturequiz->lecture_quiz_id !!}">

                                <div class="cctabs" id="cctabs{!! $lecturequiz->lecture_quiz_id !!}">
                                  <div class="cctab-link current" data-cc="1" data-tab="{!! $lecturequiz->lecture_quiz_id !!}" id="upfiletab{!! $lecturequiz->lecture_quiz_id !!}">{!! Lang::get('curriculum.Upload_File')!!}</div>
                                  <div class="cctab-link" data-cc="2" data-tab="{!! $lecturequiz->lecture_quiz_id !!}" id="fromlibrarytab{!! $lecturequiz->lecture_quiz_id !!}">{!! Lang::get('curriculum.Library')!!}</div>
                                  <div class="cctab-link" data-cc="3" data-tab="{!! $lecturequiz->lecture_quiz_id !!}" id="externalrestab{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;">{!! Lang::get('curriculum.resource')!!}</div>
                                </div>

                                <div id="upfile{!! $lecturequiz->lecture_quiz_id !!}" class="cctab-content current">
                                  <div class="row-fluid @if(!empty($lecturequiz->media) || !empty($lecturequiz->contenttext)) hideit @endif" id="wholevideos{!! $lecturequiz->lecture_quiz_id !!}">
                                    <div class="col col-lg-8" id="allbar{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;">
                                      <input type="hidden" id="probar_status_{!! $lecturequiz->lecture_quiz_id !!}" value="0" />
                                      <div class="luploadvideo-progressbar meter" ><div class="bar" id="probar{!! $lecturequiz->lecture_quiz_id !!}" style="width:0%"></div></div>
                                    </div>
                                    <div class="col col-lg-4">

                                      <div class="luploadvideo" id="videosfiles-{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;"> <input id="luploadvideo" class="videofiles" type="file" name="lecturevideo" data-url="{!! url('courses/lecturevideo/save/'.$lecturequiz->lecture_quiz_id) !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"><span>{!! Lang::get('curriculum.use_lecture_video')!!}</span></div>

                                      <div class="luploadvideo" id="audiofiles-{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;">
                                        <input id="luploadaudio" class="audiofiles luploadbtn" type="file" name="lectureaudio" data-url="{!! url('courses/lectureaudio/save/'.$lecturequiz->lecture_quiz_id) !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        <span>{!! Lang::get('curriculum.curriculum_upload')!!}</span>
                                      </div>
                                      <div class="luploadvideo" id="prefiles-{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;">
                                        <input id="luploadpre" class="prefiles luploadbtn" type="file" name="lecturepre" data-url="{!! url('courses/lecturepre/save/'.$lecturequiz->lecture_quiz_id) !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        <span>{!! Lang::get('curriculum.curriculum_pdf')!!}</span>
                                      </div>
                                      <div class="luploadvideo" id="docfiles-{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;">
                                        <input id="luploaddoc" class="docfiles luploadbtn" type="file" name="lecturedoc" data-url="{!! url('courses/lecturedoc/save/'.$lecturequiz->lecture_quiz_id) !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        <span>{!! Lang::get('curriculum.curriculum_pdfdoc')!!}</span>
                                      </div>
                                      <div class="luploadvideo" id="resfiles-{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;">
                                        <input id="luploadres" class="resfiles luploadbtn" type="file" name="lectureres" data-url="{!! url('courses/lectureres/save/'.$lecturequiz->lecture_quiz_id) !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        <span>{!! Lang::get('curriculum.curriculum_doc')!!}</span>
                                      </div>
                                    </div>
                                    <div class="col col-lg-12">
                                      <div class="width100"  id="textdescfiles-{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;">
                                        <textarea name="textdescription" id="textdesc-{!! $lecturequiz->lecture_quiz_id !!}" class="form-control curricullamEditor"></textarea>
                                        <input type="button" name="textsave" value="{!! Lang::get('curriculum.sb_save')!!}"  class="btn btn-warning savedesctext" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        <input type="button" name="canceldesctext" value="{!! Lang::get('curriculum.cancel')!!}"  class="btn btn-warning canceldesctext" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                                      </div>


                                    </div>
                                    <div class="clear"></div>
                                    <!-- <div class="col col-lg-12 buttongreen30"> <input type="button" class="change_media_btn" value="Change Media" onclick="deletemedia(692)"></div> -->
                                  </div>
                                </div>
                                <div id="fromlibrary{!! $lecturequiz->lecture_quiz_id !!}" class="cctab-content">
                                
                                  <div class="cvideofiles" id="cvideofiles{!! $lecturequiz->lecture_quiz_id !!}">
                                    @if(isset($uservideos) && !empty($uservideos))
                                    @foreach($uservideos as $video)
                                    <div class="cclickable updatelibcontent" id="cvideos{!! $lecturequiz->lecture_quiz_id !!}_{!! $video->id !!}" data-type="video" data-alt="0" data-lib="{!! $video->id !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"><i class="fa fa-play-circle-o"></i> {!! $video->video_name !!} ({!! $video->duration !!}) <!--div class="goright cvideodelete" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $video->id !!}"><i class="goright fa fa-trash-o"></i></div--></div>
                                    @endforeach
                                    @else
                                    <center><em>{!! Lang::get('curriculum.no_library')!!}</em></center>
                                    @endif
                                  </div>
                                
                                  <div class="caudiofiles" id="caudiofiles{!! $lecturequiz->lecture_quiz_id !!}">
                                    @if(isset($useraudios) && !empty($useraudios))
                                    @foreach($useraudios as $audio)
                                    <div class="cclickable updatelibcontent" id="caudios{!! $lecturequiz->lecture_quiz_id !!}_{!! $audio->id !!}" data-type="audio" data-alt="1" data-lib="{!! $audio->id !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"><i class="fa fa-volume-up"></i> {!! $audio->file_title !!} ({!! $audio->duration !!}) <!--div class="goright caudiodelete" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $audio->id !!}"><i class="goright fa fa-trash-o"></i></div--></div>
                                    @endforeach
                                    @else
                                    <center><em>{!! Lang::get('curriculum.no_library')!!}</em></center>
                                    @endif
                                  </div>
                                
                                  <div class="cprefiles" id="cprefiles{!! $lecturequiz->lecture_quiz_id !!}">
                                    @if(isset($userpresentation) && !empty($userpresentation))
                                    @foreach($userpresentation as $presentation)
                                    <div class="cclickable updatelibcontent" id="cpres{!! $lecturequiz->lecture_quiz_id !!}_{!! $presentation->id !!}" data-type="presentation" data-alt="5" data-lib="{!! $presentation->id !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"><i class="fa fa-picture-o"></i> {!! $presentation->file_title !!} ({!! ulearnHelpers::HumanFileSize($presentation->file_size) !!}) <!--div class="goright cpredelete" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $presentation->id !!}"><i class="goright fa fa-trash-o"></i></div--></div>
                                    @endforeach
                                    @else
                                    <center><em>{!! Lang::get('curriculum.no_library')!!}</em></center>
                                    @endif
                                  </div>
                                
                                  <div class="cdocfiles" id="cdocfiles{!! $lecturequiz->lecture_quiz_id !!}">
                                    @if(isset($userdocuments) && !empty($userdocuments))
                                    @foreach($userdocuments as $document)
                                    <div class="cclickable updatelibcontent" id="cdocs{!! $lecturequiz->lecture_quiz_id !!}_{!! $document->id !!}" data-type="file" data-alt="2" data-lib="{!! $document->id !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"><i class="fa fa-file-text-o"></i> {!! $document->file_title !!} ({!! ulearnHelpers::HumanFileSize($document->file_size) !!}) <!--div class="goright cdocdelete" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $document->id !!}"><i class="goright fa fa-trash-o"></i></div--></div>
                                    @endforeach
                                    @else
                                    <center><em>{!! Lang::get('curriculum.no_library')!!}</em></center>
                                    @endif
                                  </div>
                                
                                  <div class="cresfiles" id="cresfiles{!! $lecturequiz->lecture_quiz_id !!}">
                                    @if(isset($userresources) && !empty($userresources))
                                    @foreach($userresources as $resource)
                                    <div class="cclickable updaterescontent" id="cresources{!! $lecturequiz->lecture_quiz_id !!}_{!! $resource->id !!}" data-lib="{!! $resource->id !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"><i class="fa fa-file-text"></i> {!! $resource->file_title !!} ({!! ulearnHelpers::HumanFileSize($resource->file_size) !!}) <!--div class="goright cresdelete" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $resource->id !!}"><i class="goright fa fa-trash-o"></i></div--></div>
                                    @endforeach
                                    @else
                                    <center><em>{!! Lang::get('curriculum.no_library')!!}</em></center>
                                    @endif
                                  </div>
                                  
                                </div>
                                <div id="externalres{!! $lecturequiz->lecture_quiz_id !!}" class="cctab-content">
                                  
                                  <div class="form-group">
                                    <label for="label" class="col-xs-12"><p><strong>{!! Lang::get('curriculum.Title')!!}</strong></p></label>
                                    <div class="col-xs-12">
                                      <div><input class="form-control" placeholder="A Descriptive Title" id="exres_title{!! $lecturequiz->lecture_quiz_id !!}" name="exres_title" type="text" value=""></div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="label" class="col-xs-12"><p><strong> {!! Lang::get('curriculum.Link')!!}</strong></p></label>
                                    <div class="col-xs-12">
                                      <div><input class="form-control" placeholder="http://www.sample.com" id="exres_link{!! $lecturequiz->lecture_quiz_id !!}" name="exres_link" type="text" value=""></div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-xs-12">
                                      <div><input type="button" name="su_course_add_res_link_submit" value="{!! Lang::get('curriculum.Add_Link')!!}" class="btn btn-warning su_course_add_res_link_submit" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"></div>
                                    </div>
                                  </div>
                                  
                                </div>

                              </div>
                              
                                
                                
                              <div class="tips" id="videoresponse{!! $lecturequiz->lecture_quiz_id !!}">
                                @if(!empty($lecturequiz->media) || !empty($lecturequiz->contenttext))
                                
                                @if(isset($lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id]))
                                
                                
                                <div class="lecture_main_content_first_block1">
                                  <div class="lc_details @if($lecturequiz->media_type == 0) imagetype-video @elseif($lecturequiz->media_type == 1) imagetype-audio @elseif($lecturequiz->media_type == 2) imagetype-file @elseif($lecturequiz->media_type == 3) imagetype-text @elseif($lecturequiz->media_type == 5) imagetype-presentation @endif">
                                  
                                    @if($lecturequiz->media_type == 0)
                                    <div class="lecture_title">
                                      <p>{!! $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->video_name !!}</p>
                                      <p>{!! $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->duration !!}</p>
                                      <p><span class="cclickable vid_preview text-default" data-id="{!! $lecturequiz->lecture_quiz_id !!}"><i class="fa fa-play"></i>{!! Lang::get('curriculum.Video_Preview')!!}</span></p>
                                    </div>
                                    <div class="lecture_buttons">
                                      <div class="lecture_edit_content" id="lecture_edit_content{!! $lecturequiz->lecture_quiz_id !!}">
                                        <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get('curriculum.Edit_Content')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="video">
                                        <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get('curriculum.Add_Resource')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="resource">
                                        @if($lecturequiz->publish == 0)
                                        <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get('curriculum.Publish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @else
                                        <input type="button" name="lecture_unpublish_content" class="btn btn-danger unpublishcontent" value="{!! Lang::get('curriculum.Unpublish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @endif
                                      </div>
                                    </div>
                                    <div class="media_preview " id="video_preview{!! $lecturequiz->lecture_quiz_id !!}" data-lec-id="{!! $lecturequiz->lecture_quiz_id !!}">
                                      @if($lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->processed == 0)
                                      {!! Lang::get('curriculum.lecture_process') !!}
                                      @else
                                      <video class='video-js vjs-default-skin video_p_{!! $lecturequiz->lecture_quiz_id !!}' controls preload='auto' data-setup='{}'></video>
                                      <!-- <video class='video-js vjs-default-skin' controls preload='auto' data-setup='{}'><source src="{!! asset('/uploads/videos/'.$lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->video_title.'.mp4') !!}" type="video/mp4" id="videosource"><source src="{!! asset('/uploads/videos/'.$lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->video_title.'.webm') !!}" type="video/webm" id="videosource"><source src="{!! asset('/uploads/videos/'.$lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->video_title.'.ogv') !!}" type="video/ogg" id="videosource"></video> -->
                                      @endif
                                    </div>
                                    @elseif($lecturequiz->media_type == 1)
                                    <div class="lecture_title">
                                      <p>{!! $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->file_title !!}</p>
                                      <p>{!! $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->duration !!}</p>
                                      <p><span class="cclickable aud_preview text-default" data-id="{!! $lecturequiz->lecture_quiz_id !!}"><i class="fa fa-play"></i> {!! Lang::get('curriculum.Audio_Preview')!!}</span></p>
                                    </div>
                                    <div class="lecture_buttons">
                                      <div class="lecture_edit_content" id="lecture_edit_content{!! $lecturequiz->lecture_quiz_id !!}">
                                        <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get('curriculum.Edit_Content')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="audio">
                                        <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get('curriculum.Add_Resource')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="resource">
                                        @if($lecturequiz->publish == 0)
                                        <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get('curriculum.Publish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @else
                                        <input type="button" name="lecture_unpublish_content" class="btn btn-danger unpublishcontent" value="{!! Lang::get('curriculum.Unpublish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @endif
                                      </div>
                                    </div>
                                    <div class="media_preview" id="audio_preview{!! $lecturequiz->lecture_quiz_id !!}">
                                      @if($lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->processed == 0)
                                        {!! Lang::get('curriculum.lecture_process') !!}
                                        @else
                                        <audio controls><source src="{{ Storage::url('course/'.$course_id.'/'.$lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->file_name.'.mp3') }}" type="audio/mpeg">{!! Lang::get('curriculum.browser_support')!!}</audio>
                                        @endif
                                    </div>
                                    @elseif($lecturequiz->media_type == 2)
                                    <div class="lecture_title">
                                      <p>{!! $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->file_title !!}</p>
                                      @php $pdfpages = $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->duration; @endphp 
                                      <p>@if($pdfpages <= 1) {!! $pdfpage = $pdfpages.' Page' !!} @else {!! $pdfpage = $pdfpages.' Pages' !!} @endif</p>
                                    </div>
                                    <div class="lecture_buttons">
                                      <div class="lecture_edit_content" id="lecture_edit_content{!! $lecturequiz->lecture_quiz_id !!}">
                                        <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get('curriculum.Edit_Content')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="file">
                                        <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get('curriculum.Add_Resource')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="resource">
                                        @if($lecturequiz->publish == 0)
                                        <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get('curriculum.Publish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @else
                                        <input type="button" name="lecture_unpublish_content" class="btn btn-danger unpublishcontent" value="{!! Lang::get('curriculum.Unpublish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @endif
                                      </div>
                                    </div>
                                    @elseif($lecturequiz->media_type == 3)
                                    <div class="lecture_title">
                                      <p>{!! Lang::get('curriculum.Text')!!}</p>
                                    </div>
                                    <div class="lecture_buttons">
                                      <div class="lecture_edit_content" id="lecture_edit_content{!! $lecturequiz->lecture_quiz_id !!}">
                                        <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get('curriculum.Edit_Content')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="text">
                                        <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get('curriculum.Add_Resource')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="resource">
                                        @if($lecturequiz->publish == 0)
                                        <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get('curriculum.Publish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @else
                                        <input type="button" name="lecture_unpublish_content" class="btn btn-danger unpublishcontent" value="{!! Lang::get('curriculum.Unpublish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @endif
                                      </div>
                                      <div class="">
                                        
                                      </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="lecture_contenttext" id="lecture_contenttext{!! $lecturequiz->lecture_quiz_id !!}">
                                      {!! $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id] !!}
                                    </div>
                                    @elseif($lecturequiz->media_type == 5)
                                    <div class="lecture_title">
                                      <p>{!! $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->file_title !!}</p>
                                      @php $pdfpages = $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->duration; @endphp 
                                      <p>@if($pdfpages <= 1) {!! $pdfpage = $pdfpages.' Page' !!} @else {!! $pdfpage = $pdfpages.' Pages' !!} @endif</p>
                                    </div>
                                    <div class="lecture_buttons">
                                      <div class="lecture_edit_content" id="lecture_edit_content{!! $lecturequiz->lecture_quiz_id !!}">
                                        <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get('curriculum.Edit_Content')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="presentation">
                                        <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get('curriculum.Add_Resource')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}" data-alt="resource">
                                        @if($lecturequiz->publish == 0)
                                        <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get('curriculum.Publish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @else
                                        <input type="button" name="lecture_unpublish_content" class="btn btn-danger unpublishcontent" value="{!! Lang::get('curriculum.Unpublish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                        @endif
                                      </div>
                                    </div>
                                    @endif
                                  
                                  </div>
                                
                                </div>
                                @endif
                                @endif
                              
                              </div>
                              <div id="resresponse{!! $lecturequiz->lecture_quiz_id !!}"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- add video end -->

                    <!-- add description start -->

                    <div class="su_course_add_lecture_desc_content su_course_add_content_desc_form @if(empty($lecturequiz->description)) hideit editing @endif" id="adddescblock-{!! $lecturequiz->lecture_quiz_id !!}">
                      <div class="divtitlehead"><p><strong>{!! Lang::get('curriculum.Description')!!}</strong></p></div>
                      <div class="formrow @if(empty($lecturequiz->description)) hideit @endif" id="descblock{!! $lecturequiz->lecture_quiz_id !!}">
                        <div class="row-fluid">
                          <div class="editdescription" id="descriptions{!! $lecturequiz->lecture_quiz_id !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">{!! $lecturequiz->description !!}</div>
                        </div>
                      </div>
                      
                      <div class="formrow @if(!empty($lecturequiz->description)) hideit @endif" id="editblock{!! $lecturequiz->lecture_quiz_id !!}">
                        <div class="row-fluid">
                          <!-- <div class="col col-lg-3"><label>Lecture Description: </label></div> -->
                          <div class="col col-lg-12"><textarea name="lecturedescription" id="lecturedesc-{!! $lecturequiz->lecture_quiz_id !!}" class="form-control curricullamEditor"></textarea></div>
                        </div>
                      </div>

                      <div class="formrow @if(!empty($lecturequiz->description)) hideit @endif" id="editblockfooter{!! $lecturequiz->lecture_quiz_id !!}">
                        <div class="row-fluid">
                          <div class="col col-lg-12"> 
                            <input type="button" name="su_course_add_lecture_desc_submit" value="{!! Lang::get('curriculum.sb_save')!!}" class="btn btn-warning su_course_add_lecture_desc_submit"  data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                            <input type="button" id="btn_description" name="su_course_add_lecture_desc_cancel" value="{!! Lang::get('curriculum.cancel')!!}" class="btn btn-warning su_course_add_lecture_desc_cancel" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}"></div>
                        </div>
                      </div>

                    </div>

                    <!-- add description end -->

                    <!-- list resources start -->
                    <div class="su_course_add_lecture_desc_content @if(!isset($lecturesresources[$section->section_id][$lecturequiz->lecture_quiz_id])) hideit @endif" id="resourceblock{!! $lecturequiz->lecture_quiz_id !!}">
                      <div class="divtitlehead"><p><strong>{!! Lang::get('curriculum.Resources')!!}</strong></p></div>
                      <div class="formrow">
                        <div class="row-fluid resourcefiles">
                          @if(isset($lecturesresources[$section->section_id][$lecturequiz->lecture_quiz_id]))
                          @foreach($lecturesresources[$section->section_id][$lecturequiz->lecture_quiz_id] as $resources)
                          @foreach($resources as $resource)
                          <div id="resources{!! $lecturequiz->lecture_quiz_id !!}_{!! $resource->id !!}"> @if($resource->file_type == 'link') <i class="fa fa-external-link"></i> {!! $resource->file_title !!} @else <i class="fa fa-download"></i> {!! $resource->file_title !!} ({!! ulearnHelpers::HumanFileSize($resource->file_size) !!}) @endif <div class="goright resdelete" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $resource->id !!}"><i class="goright fa fa-trash-o"></i></div></div>
                          @endforeach
                          @endforeach
                          @endif
                        </div>
                      </div>
                    </div>
                    <!-- list resources end -->

                  </li>
                  @php $lecturecount++; @endphp
                  @elseif($lecturequiz->type == 1)
                  <li class="lq_sort_quiz su_lgray_curr quiz quiz-{!! $lecturequiz->lecture_quiz_id !!} parent-s-{!! $section->section_id !!}">
                    <div class="row-fluid sorthandle">
                      <div class="col col-lg-12">
                        <div class="su_course_quiz_label @if($lecturequiz->publish == 1) su_green_curr_block @else su_lgray_curr_block @endif">
                          <div class="edit_option edit_option_quiz">{!! Lang::get('curriculum.Quiz')!!} <span class="serialno">{!! $quizcount !!}</span>: <label class="slqtitle">{!! $lecturequiz->title !!}</label>
                            <input type="text" maxlength="80" class="chcountfield su_course_update_quiz_textbox" value="{!! $lecturequiz->title !!}">
                            <span class="ch-count">{!! 80-strlen($lecturequiz->title) !!}</span>
                          </div>
                          <input type="hidden" value="{!! $lecturequiz->lecture_quiz_id !!}" class="quizid" name="quizids[]">
                          <input type="hidden" value="{!! $lecturequiz->sort_order !!}" class="quizpos" name="quizposition[]">
                          <input type="hidden" value="{!! $section->section_id !!}" class="quizsectionid" name="quizsectionid">
                          <div class="deletequiz" onclick="deletequiz({!! $lecturequiz->lecture_quiz_id !!},{!! $section->section_id !!})"></div>
                          <div class="updatequiz" onclick="updatequiz({!! $lecturequiz->lecture_quiz_id !!},{!! $section->section_id !!})"></div>
                          <div class="lecture_add_content" id="lecture_add_quiz{!! $lecturequiz->lecture_quiz_id !!}">
                            <input type="button" name="lecture_add_quiz" value="Add Questions" class="addquestions" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                            <div class="closeheader">
                              <span class="closetext"></span>
                              <input type="button" name="lecture_close_question" value="X" class="btn-danger closequestion" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- list quiz questions start -->
                    <div class="su_course_add_lecture_desc_content @if(!isset($lecturesquizquestions[$section->section_id][$lecturequiz->lecture_quiz_id]) || empty($lecturesquizquestions[$section->section_id][$lecturequiz->lecture_quiz_id])) hideit nondata @endif" id="questionsblock{!! $lecturequiz->lecture_quiz_id !!}">
                      <div class="lecture_buttons lecture_edit_content">
                        @if($lecturequiz->publish == 0)
                        <input type="button" name="lecture_publish_content_quiz" class="btn btn-warning publishcontentquiz" value="{!! Lang::get('curriculum.Publish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                        @else
                        <input type="button" name="lecture_unpublish_content_quiz" class="btn btn-danger unpublishcontentquiz" value="{!! Lang::get('curriculum.Unpublish')!!}" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                        @endif
                      </div>
                      <div class="divtitlehead"><p><strong>{!! Lang::get('curriculum.Questions')!!}</strong></p></div>
                      <div class="formrow questionlist">
                        <div class="row-fluid quizquestions" id="quizquestions{!! $lecturequiz->lecture_quiz_id !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                          @if(isset($lecturesquizquestions[$section->section_id][$lecturequiz->lecture_quiz_id]))
                          @php $quescount=1; @endphp
                          @foreach($lecturesquizquestions[$section->section_id][$lecturequiz->lecture_quiz_id] as $question)
                          <div class="quescount" id="questions{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}"> @if($question->question_type == '0') <i class="fa fa-list"></i>  @else <i class="fa fa-check"></i> @endif <span id="quescount{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}">{!! $quescount !!}</span>. {!! substr(strip_tags($question->question), 0, 56) !!}  <div class="goright quessort" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $question->quiz_question_id !!}"><i class="goright fa fa-align-justify"></i></div><div class="goright quesdelete" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $question->quiz_question_id !!}"><i class="goright fa fa-trash-o"></i></div> <div class="goright quesedit" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-rid="{!! $question->quiz_question_id !!}" data-ltype="{!! $question->question_type !!}"><i class="goright fa fa-pencil"></i></div> <input type="hidden" value="{!! $question->quiz_question_id !!}" class="quizquestionid"></div>
                          @php $quescount++; @endphp
                          @endforeach
                          @endif
                        </div>
                      </div>
                    </div>
                    <!-- list quiz questions end -->

                    <!-- add question block start -->
                    <div class="lecturepopup hideit" id="quesblock-{!! $lecturequiz->lecture_quiz_id !!}">
                      <div class="quizques">
                        <div class="quiz-type">
                          <div class="clearfix">
                            <div class="divli lquiz-multiple" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"  alt="multiple"><div class="quiztype"><span>{!! Lang::get('curriculum.Multiple Choice')!!}</span></div><label>{!! Lang::get('curriculum.Multiple_Choice')!!}</label><div class="innershadowquiz"></div></div>
                            <div class="divli lquiz-truefalse" data-lid="{!! $lecturequiz->lecture_quiz_id !!}"  alt="truefalse"><div class="quiztype"><span>{!! Lang::get('curriculum.true_false')!!}</span></div><label>{!! Lang::get('curriculum.true_false')!!}</label><div class="innershadowquiz"></div></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Add question block end -->

                    <!-- Question content -->
                    <div class="lecturepopup hideit" id="contentques-{!! $lecturequiz->lecture_quiz_id !!}">
                      <div class="quizques">
                        <div class="divtitlehead"><p><strong>{!! Lang::get('curriculum.Questions')!!}</strong></p></div>
                        
                        <div class="formrow margbot">
                          <div class="row-fluid">
                            <div><textarea name="quizquestion" id="quizquestion-{!! $lecturequiz->lecture_quiz_id !!}" class="form-control curricullamEditor"></textarea></div>
                          </div>
                        </div>
                        
                        <div class="divtitlehead"><p><strong>{!! Lang::get('curriculum.Answers')!!}</strong></p></div>
                        <div class="qmultiple hideit" id="multipleques-{!! $lecturequiz->lecture_quiz_id !!}">
                          <div class="divtitlesub"><p>{!! Lang::get('curriculum.ans_writeup')!!}</p></div>
                          <div class="qanswer">
                            <div class="col col-lg-12">
                              <input type="radio" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}" value="1">
                              <input type="text" placeholder="{!! Lang::get('curriculum.Add_an_answer')!!}" class="chcountfield count600 answer" maxlength="600" name="answers[]" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                              <span class="answers-counter ch-count">600</span>
                            </div>
                            <div class="col col-lg-12">
                              <input type="text" placeholder="{!! Lang::get('curriculum.best_answer')!!}" class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]">
                              <span class="answers-feedback-counter ch-count">600</span>
                            </div>
                          </div>
                          <div class="qanswer">
                            <div class="col col-lg-12">
                              <input type="radio" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}" value="2">
                              <input type="text" placeholder="{!! Lang::get('curriculum.Add_an_answer')!!}" class="chcountfield count600 answer" maxlength="600" name="answers[]" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                              <span class="answers-counter ch-count">600</span>
                            </div>
                            <div class="col col-lg-12">
                              <input type="text" placeholder="{!! Lang::get('curriculum.best_answer')!!}" class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]">
                              <span class="answers-feedback-counter ch-count">600</span>
                            </div>
                          </div>
                          <div class="qanswer">
                            <div class="col col-lg-12">
                              <div class="delques"><i class="fa fa-trash-o"></i></div>
                              <input type="radio" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}" value="3">
                              <input type="text" placeholder="{!! Lang::get('curriculum.Add_an_answer')!!}" class="chcountfield count600 qlastchild answer" maxlength="600" name="answers[]" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                              <span class="answers-counter ch-count">600</span>
                            </div>
                            <div class="col col-lg-12">
                              <input type="text" placeholder="{!! Lang::get('curriculum.best_answer')!!}" class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]">
                              <span class="answers-feedback-counter ch-count">600</span>
                            </div>
                          </div>
                        </div>
                        
                        <div class="qtruefalse hideit" id="truefalseques-{!! $lecturequiz->lecture_quiz_id !!}">
                          <div class="divtitlesub"><p>{!! Lang::get('curriculum.quiz_msg')!!}</p></div>
                          <div class="formrow">
                            <div class="row-fluid">
                              <div class="col col-lg-2">
                                <input type="radio" id="radtrue{!! $lecturequiz->lecture_quiz_id !!}" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}" value="1"> {!! Lang::get('curriculum.True')!!}
                              </div>
                              <div class="col col-lg-2">
                                <input type="radio" id="radfalse{!! $lecturequiz->lecture_quiz_id !!}" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}" value="2"> {!! Lang::get('curriculum.False')!!}
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="formrow">
                          <div class="row-fluid">
                            <input type="button" name="su_course_add_quiz_question_submit" value="{!! Lang::get('curriculum.sb_save')!!}" class="btn btn-warning su_course_add_quiz_question_submit"  data-lid="{!! $lecturequiz->lecture_quiz_id !!}"> 
                            <input type="hidden" value="0" id="quiztype{!! $lecturequiz->lecture_quiz_id !!}">
                            <input type="hidden" value="0" id="coption{!! $lecturequiz->lecture_quiz_id !!}">
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Question content end -->

                    <!-- Question edit content -->
                    <div class="lecturepopup hideit editquestionpart" id="editquestionpart{!! $lecturequiz->lecture_quiz_id !!}">
                      @if(isset($lecturesquizquestions[$section->section_id][$lecturequiz->lecture_quiz_id]))
                      @foreach($lecturesquizquestions[$section->section_id][$lecturequiz->lecture_quiz_id] as $question)
                      <div class="contenteditques" id="contenteditques-{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}">
                        <div class="quizques">
                          <div class="divtitlehead"><p><strong>{!! Lang::get('curriculum.Questions')!!}</strong></p></div>
                          
                          <div class="formrow margbot">
                            <div class="row-fluid">
                              <div><textarea name="quizquestion" id="quizeditquestion-{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}" class="form-control curricullamEditor">{!! $question->question !!}</textarea></div>
                            </div>
                          </div>
                          
                          <div class="divtitlehead"><p><strong>{!! Lang::get('curriculum.Answers')!!}</strong></p></div>
                          @if($question->question_type == 0)
                          <div class="qmultiple" id="multipleeditques-{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}">
                            <div class="divtitlesub"><p>{!! Lang::get('curriculum.ans_writeup')!!}</p></div>
                            @php $quesanswers = json_decode($question->options); $anscount=1; $countans = count($quesanswers); @endphp
                            @foreach($quesanswers as $answer)
                            <div class="qanswer">
                              <div class="col col-lg-12">
                                @if($anscount > 2)
                                <div class="deleditques"><i class="fa fa-trash-o"></i></div>
                                @endif
                                <input type="radio" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}" value="{!! $anscount !!}" @if($anscount == $question->correct_option) checked="checked" @endif>
                                <input type="text" placeholder="{!! Lang::get('curriculum.Add_an_answer')!!}" class="chcountfield count600 answer" maxlength="600" name="answers[]" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" value="{!! $answer->answer !!}">
                                <span class="answers-counter ch-count">{!! 600-strlen($answer->answer) !!}</span>
                              </div>
                              <div class="col col-lg-12">
                                <input type="text" placeholder="{!! Lang::get('curriculum.best_answer')!!}" class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]" value="{!! $answer->feedback !!}">
                                <span class="answers-feedback-counter ch-count">{!! 600-strlen($answer->feedback) !!}</span>
                              </div>
                            </div>
                            @php $anscount++; @endphp
                            @endforeach
                            <div class="qanswer">
                              <div class="col col-lg-12">
                                <div class="deleditques"><i class="fa fa-trash-o"></i></div>
                                <input type="radio" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}" value="{!! $countans+1 !!}">
                                <input type="text" placeholder="{!! Lang::get('curriculum.Add_an_answer')!!}" class="chcountfield count600 qlasteditchild answer" maxlength="600" name="answers[]" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                                <span class="answers-counter ch-count">600</span>
                              </div>
                              <div class="col col-lg-12">
                                <input type="text" placeholder="{!! Lang::get('curriculum.best_answer')!!}" class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]">
                                <span class="answers-feedback-counter ch-count">600</span>
                              </div>
                            </div>
                          </div>
                          @elseif($question->question_type == 1)
                          <div class="qtruefalse" id="truefalseeditques-{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}">
                            <div class="divtitlesub"><p>{!! Lang::get('curriculum.quiz_msg')!!}</p></div>
                            <div class="formrow">
                              <div class="row-fluid">
                                <div class="col col-lg-2">
                                  <input type="radio" id="radtrue{!! $lecturequiz->lecture_quiz_id !!}" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}" value="1" @if(1 == $question->correct_option) checked="checked" @endif> {!! Lang::get('curriculum.True')!!}
                                </div>
                                <div class="col col-lg-2">
                                  <input type="radio" id="radfalse{!! $lecturequiz->lecture_quiz_id !!}" name="answers-radio{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}" value="2" @if(2 == $question->correct_option) checked="checked" @endif> {!! Lang::get('curriculum.False')!!}
                                </div>
                              </div>
                            </div>
                          </div>
                          @endif
                          <div class="formrow">
                            <div class="row-fluid">
                              <input type="button" name="su_course_add_quiz_question_update" value="{!! Lang::get('curriculum.sb_save')!!}" class="btn btn-warning su_course_add_quiz_question_update" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" data-qid="{!! $question->quiz_question_id !!}"> 
                              <input type="hidden" value="{!! $question->question_type !!}" id="quiztype{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}">
                              <input type="hidden" value="{!! $question->correct_option !!}" id="coption{!! $lecturequiz->lecture_quiz_id !!}_{!! $question->quiz_question_id !!}">
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      @endif
                    </div>
                    <!-- Question edit content end -->
                    
                    <div class="su_course_add_lecture_desc_content quizeditdesc" id="quizeditdesc{!! $lecturequiz->lecture_quiz_id !!}">
                      <div class="divtitlehead"><p><strong> {!! Lang::get('curriculum.Description')!!}</strong></p></div>
                      <textarea name="lectureeditdescription" id="lectureeditdesc-{!! $lecturequiz->lecture_quiz_id !!}" class="form-control curricullamEditor"></textarea>
                      <div class="quizeditdescription" id="quizeditdescription{!! $lecturequiz->lecture_quiz_id !!}">{!! $lecturequiz->description !!}</div>
                    </div>
                    
                  </li>
                  @php $quizcount++; @endphp
                  @endif
                  @endforeach
                  @endif
                  
                  @php $sectioncount++; @endphp
                  @endforeach
                </ul>
              </div>

              <div class="su_course_curriculam_default">
                <ul class="clearfix">
                  <li class="su_blue_curr">
                    <div class="col col-lg-12">
                      <div class="row-fluid add_quiz_lecture_part">
                        <div class="col col-lg-6">
                          <div class="su_course_add_lecture_label su_blue_curr_block">
                            <span> {!! Lang::get('curriculum.Add_Lecture')!!}</span>
                          </div>
                        </div>
                        
                      </div>

                      <div class="su_course_add_lecture_content su_course_add_content_form">
                        <div class="formrow">
                          <div class="row-fluid">
                            <div class="col col-lg-3">
                              <label>{!! Lang::get('curriculum.New_Lecture')!!}: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col col-lg-9">
                              <input type="text" id="new_lecture" name="su_course_add_lecture_textbox" value="" placeholder="{!! Lang::get('curriculum.quiz_title')!!}" class="form-element su_course_add_lecture_textbox chcountfield" maxlength="80">
                              <span id="lecture_title_counter" class="ch-count">80</span>
                            </div>
                          </div>
                        </div>
                        <div class="formrow">
                          <div class="row-fluid">
                            <div class="col col-lg-9">
                              <input type="button" name="su_course_add_lecture_submit" value="{!! Lang::get('curriculum.Add_Lecture')!!}" class="btn btn-warning su_course_add_lecture_submit">
                              <input type="button" id="btn_lecture" name="su_course_add_lecture_cancel" value="{!! Lang::get('curriculum.cancel')!!}" class="btn btn-warning su_course_add_lecture_cancel">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="su_course_add_quiz_content su_course_add_content_form su_course_add_quiz_form">
                        <div class="formrow">
                          <div class="row-fluid">
                            <div class="col col-lg-3">
                              <label>{!! Lang::get('curriculum.New_Quiz')!!}: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col col-lg-9">
                              <input type="text" id="new_quiz" name="su_course_add_quiz_textbox" value="" placeholder="{!! Lang::get('curriculum.quiz_title')!!}" class="form-element su_course_add_quiz_textbox chcountfield" maxlength="80">
                              <span id="quiz_title_counter" class="ch-count">80</span>
                            </div>
                          </div>
                        </div>
                        <div class="formrow">
                          <div class="row-fluid">
                            <div class="col col-lg-3">
                              <label> {!! Lang::get('curriculum.Description')!!}: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col col-lg-9">
                              <div><textarea name="quizdescription" id="quizdesc" class="form-control curricullamEditor su_course_add_quiz_desc"></textarea></div>
                            </div>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="formrow">
                          <div class="row-fluid">
                            <div class="col col-lg-9">
                              <input type="button" name="su_course_add_quiz_submit" value=" {!! Lang::get('curriculum.Add_Quiz')!!}" class="btn btn-warning su_course_add_quiz_submit">
                              <input type="button" id="btn_quiz" name="su_course_add_quiz_cancel" value=" {!! Lang::get('curriculum.cancel')!!}" class="btn btn-warning su_course_add_quiz_cancel">
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </li>

                  <li class="su_gray_curr">
                    <div class="row-fluid">
                      <div class="col col-lg-12">
                        <div class="su_course_add_section_label su_gray_curr_block">
                          <span> {!! Lang::get('curriculum.Add_Section')!!}</span>
                        </div>

                        <div class="su_course_add_section_content su_course_add_content_form">
                          <div class="formrow">
                            <div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('curriculum.New_Section')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="text" id="new_section" name="su_course_add_section_textbox" value="" placeholder="{!! Lang::get('curriculum.quiz_title')!!}" class="form-element su_course_add_section_textbox chcountfield" maxlength="80">
                                <span id="section_title_counter" class="ch-count">80</span>
                              </div>
                            </div>
                          </div>
                          <div class="formrow">
                            <div class="row-fluid">
                              <div class="col col-lg-9">
                                <input type="button" name="su_course_add_section_submit" value="{!! Lang::get('curriculum.Add_Section')!!}" class="btn btn-warning su_course_add_section_submit">
                                <input type="button" id="btn_section" name="su_course_add_section_cancel" value="{!! Lang::get('curriculum.cancel')!!}" class="btn btn-warning su_course_add_section_cancel">
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </li>


                </ul>
              </div>

            </div>

            </form>


          </div>
        </div>
      </div> 

    </div>

  </div>
</div>
</div>
    <!-- curriculum end -->
    
  </div>
</div>

       
      <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.ui.widget.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload-process.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload-validate.js') }}"></script>

<script type="text/javascript">
$('.curriculam-block').bind({
    dragenter: function(e) {
        $(this).addClass('highlighted');
        return false;
    },
    dragover: function(e) {
        e.stopPropagation();
        e.preventDefault();
        return false;
    },
    dragleave: function(e) {
        $(this).removeClass('highlighted');
        return false;
    },
    drop: function(e) {
        var dt = e.originalEvent.dataTransfer;
        console.log(dt.files.length);
        return false;
    }
});

$(document).bind({
    dragenter: function(e) {
        e.stopPropagation();
        e.preventDefault();
        var dt = e.originalEvent.dataTransfer;
        dt.effectAllowed = dt.dropEffect = 'none';
    },
    dragover: function(e) {
        e.stopPropagation();
        e.preventDefault();
        var dt = e.originalEvent.dataTransfer;
        dt.effectAllowed = dt.dropEffect = 'none';
    }
});

$(document).ready(function(){
          
    $("#btn_lecture").click(function () {
        $('#new_lecture').val('');
        }); 
    $("#btn_quiz").click(function () {
        $('#new_quiz').val('');   
        tinyMCE.activeEditor.setContent("");
        }); 
    $("#btn_section").click(function () {
        $('#new_section').val('');
        }); 
    $("#btn_lecture").click(function () {
        $('#new_lecture').val('');
        }); 
  $(document).on('click','div.cctabs .cctab-link',function(){
    var tab_id = $(this).attr('data-tab');
    var tab_cc = $(this).attr('data-cc');
    
    if(tab_cc == '1'){
      $("#fromlibrary"+tab_id).removeClass('current');
      $("#fromlibrarytab"+tab_id).removeClass('current');
      $("#externalres"+tab_id).removeClass('current');
      $("#externalrestab"+tab_id).removeClass('current');
      $("#upfile"+tab_id).addClass('current');
      $("#upfiletab"+tab_id).addClass('current');
    } else if(tab_cc == '2'){
      $("#upfile"+tab_id).removeClass('current');
      $("#upfiletab"+tab_id).removeClass('current');
      $("#externalres"+tab_id).removeClass('current');
      $("#externalrestab"+tab_id).removeClass('current');
      $("#fromlibrary"+tab_id).addClass('current');
      $("#fromlibrarytab"+tab_id).addClass('current');
    } else if(tab_cc == '3'){
      $("#upfile"+tab_id).removeClass('current');
      $("#upfiletab"+tab_id).removeClass('current');
      $("#fromlibrary"+tab_id).removeClass('current');
      $("#fromlibrarytab"+tab_id).removeClass('current');
      $("#externalres"+tab_id).addClass('current');
      $("#externalrestab"+tab_id).addClass('current');
    }

    //remove error message
    $('#resresponse'+tab_id+' p').text(" ");

  });
  
  $(document).on('input','.chcountfield', function() {
    var len = $(this).val().length;
    var setval = parseInt('80')-parseInt(len);
    $(this).next('.ch-count').text(setval);
  });
  $(document).on('input','.count600', function() {
    var len = $(this).val().length;
    var setval = parseInt('600')-parseInt(len);
    $(this).next('.ch-count').text(setval);
  });
  
  tinymce.init({  
    mode : "specific_textareas",
    editor_selector : "curricullamEditor",
    theme : "advanced",
    theme_advanced_buttons1 : "bold,italic,underline",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    width : "100%",
    plugins : "paste",
    paste_text_sticky : true,
    setup : function(ed) {
      ed.onInit.add(function(ed) {
        ed.pasteAsPlainText = true;
      });
    }
  });
  $('.curriculam_page').addClass('active');

  $( ".quizquestions" ).sortable({
    handle : '.quessort',
    update: function(e, ui) { 
      updatequizsorting($(this).data('lid'));
    }
  });
  
  $( ".su_course_curriculam_sortable ul" ).sortable({
  
  handle : '.sorthandle',
  connectWith : '.su_course_curriculam_sortable ul',

  //  update function 
  update: function(e, ui) { 

  // check lecture under section
  if($('.su_course_curriculam_sortable li:first-child').hasClass('childli')) {
    $(this).sortable('cancel');
    $(ui.sender).sortable('cancel');
  }
  // check quiz under section
  if($('.su_course_curriculam_sortable li:first-child').hasClass('quiz')) {
    $(this).sortable('cancel');
    $(ui.sender).sortable('cancel');
  }
   
  updatesorting();


  },
  start: function(e, ui){
    $(this).find('.curricullamEditor').each(function(){
      tinyMCE.execCommand( 'mceRemoveControl', false, $(this).attr('id') );
      $(this).hide();
    });
  },
  stop: function(e,ui) {
    $(this).find('.curricullamEditor').each(function(){
      $(this).show();
      tinyMCE.execCommand( 'mceAddControl', true, $(this).attr('id') );
      //$(this).sortable("refresh");
    });
  }

});

    /*
     * Adding new section
     */ 
    $('.su_course_add_section_label').click(function(){
      $(this).hide();
      $('.su_course_add_section_content').show();
    $('#section_title_counter').text('80');
    });

    $('.su_course_add_section_cancel').click(function(){
      $(this).parents('.su_course_add_section_content').hide();
      $('.su_course_add_section_label').show();
      $('.su_course_add_section_textbox').removeClass('error');
    });

  //Add new section for course
  $('.su_course_add_section_submit').click(function(){
    $('.su_course_add_section_submit').prop("disabled", true);
    if($.trim($('.su_course_add_section_textbox').val()).length >= 2) {
      var sno=$('.su_course_curriculam li.parentli').length+1;
      var cno=sno+1;
      var sval=$('.su_course_add_section_textbox').val();
      var courseid=$('[name="course_id"]').val();
      var coursesection=$('[name="coursesection"]').val();
      var _token=$('[name="_token"]').val();
      
      $.ajax ({
        type: "POST",
        url: coursesection,
        data: "&courseid="+courseid+"&section="+sval+"&position="+sno+"&id=0"+"&_token="+_token,
        success: function (msg)
        {
          
          $('.su_course_curriculam_sortable ul').append('<li class="su_gray_curr parentli section-'+msg+'"><div class="row-fluid sorthandle"><div class="col col-lg-12"><div class="su_course_section_label su_gray_curr_block"><div class="edit_option edit_option_section">Section <span class="serialno">'+sno+'</span>: <label  class="slqtitle">'+sval+'</label> <input type="text" maxlength="80" class="chcountfield su_course_update_section_textbox" value="'+sval+'" /><span class="ch-count">'+(80-sval.length)+'</span></div> <input type="hidden" value="'+msg+'" class="sectionid" name="sectionids[]"/> <input type="hidden" value="'+sno+'" class="sectionpos" name="sectionposition[]"/><div class="deletesection" onclick="deletesection('+msg+')"></div><div class="updatesection" onclick="updatesection('+msg+')"></div></div></div></div></li>');
          $('.su_course_add_section_textbox').val('')
          $('.su_course_add_section_label').show();
          $('.su_course_add_section_content').hide();
          $('.su_course_add_section_submit').prop("disabled", false);
        }
      });
    } else {
      $('.su_course_add_section_textbox').addClass('error');
      $('.su_course_add_section_submit').prop("disabled", false);
    }
  });

  //Add new lecture for course
  $('.su_course_add_lecture_submit').click(function(){
    $('.su_course_add_lecture_submit').prop("disabled", true);
    if($.trim($('.su_course_add_lecture_textbox').val()).length>1) {
      var sid=$('.su_course_curriculam_sortable li.parentli').last().find('.sectionid').val();
      var sno=1
      $( '.childli' ).each(function(){
        sno++;
      });
      var lqno=1;
      $( '.lq_sort' ).each(function(){
        lqno++;
      });
      var cno=$('.su_course_curriculam_sortable li.childli').length+2;
      var sval=$('.su_course_add_lecture_textbox').val();
      var courseid=$('[name="course_id"]').val();
      var courselecture=$('[name="courselecture"]').val();
      var _token=$('[name="_token"]').val();

      
      $.ajax ({
        type: "POST",
        url: courselecture,
        data: "&courseid="+courseid+"&lecture="+sval+"&position="+lqno+"&sectionid="+sid+"&_token="+_token,
        success: function (msg)
        {
          $('.su_course_add_lecture_submit').prop("disabled", false);
          
          $('.su_course_curriculam_sortable ul').append('<li class="lq_sort su_lgray_curr childli lecture-'+msg+' lecture parent-s-'+sid+'" ><div class="row-fluid sorthandle"><div class="col col-lg-12"><div class="su_course_lecture_label su_lgray_curr_block"><div class="edit_option edit_option_lecture">Lecture <span class="serialno">'+sno+'</span>: <label class="slqtitle">'+sval+'</label> <input type="text" maxlength="80" class="chcountfield su_course_update_lecture_textbox" value="'+sval+'" /><span class="ch-count">'+(80-sval.length)+'</span></div> <input type="hidden" value="'+msg+'" class="lectureid" name="lectureids[]"/> <input type="hidden" value="'+lqno+'" class="lecturepos" name="lectureposition[]"/> <input type="hidden" value="'+sid+'" class="lecturesectionid" name="lecturesectionid"/><div class="deletelecture" onclick="deletelecture('+msg+','+sid+')"></div><div class="updatelecture" onclick="updatelecture('+msg+','+sid+')"></div><div class="lecture_add_content" id="lecture_add_content'+msg+'"> <input type="button" name="lecture_add_content" class="adddescription" value="{!! Lang::get("curriculum.Add_Description") !!}" data-blockid="'+msg+'"> <input type="button" name="lecture_add_content" class="addcontents" value="Add Content" data-blockid="'+msg+'"> <div class="closeheader"><span class="closetext">Select Content Type</span><input type="button" name="lecture_close_content" value="X" class="btn-danger closecontents" data-blockid="'+msg+'"></div></div></div></div></div> <div class="lecturepopup" id="wholeblock-'+msg+'" style="display:none;"><div class="lecturecontent" ><div class="lecture-media"><div class="clearfix"><div class="divli lmedia-video" data-lid="'+msg+'"  alt="video"><div class="lecturemedia"><span>Video</span></div><label>Video</label><div class="innershadow"></div></div><div class="divli lmedia-audio" data-lid="'+msg+'" alt="audio"><div class="lecturemedia"><span>Audio</span></div><label>Audio</label><div class="innershadow"></div></div><!--div class="divli lmedia-presentation" data-lid="'+msg+'" alt="presentation"><div class="lecturemedia"><span>Presentation</span></div><label>Presentation</label><div class="innershadow"></div></div--><div class="divli lmedia-file" data-lid="'+msg+'" alt="file"><div class="lecturemedia"><span>Document</span></div><label>Document</label><div class="innershadow"></div></div><div class="divli lmedia-text" data-lid="'+msg+'" alt="text"><div class="lecturemedia"><span>Text</span></div><label>Text</label><div class="innershadow"></div></div></div></div></div> </div>          <div class="lecturepopup hideit" id="contentpopshow'+msg+'"><div class="lecturecontent_inner ltwovideo"><div class="lecturecontent_video lecturecontent_tab"><div class="lecturecontent_video_content lecturecontent_tab_content"><div id="uploadvideo'+msg+'" class="uploadvideo" style="display: block;"> <div class="cccontainer" id="cccontainer'+msg+'"> <div class="cctabs" id="cctabs'+msg+'"> <div class="cctab-link current" data-cc="1" data-tab="'+msg+'" id="upfiletab'+msg+'">Upload File</div> <div class="cctab-link" data-cc="2" data-tab="'+msg+'" id="fromlibrarytab'+msg+'">Add from Library</div> <div class="cctab-link" data-cc="3" data-tab="'+msg+'" id="externalrestab'+msg+'" style="display:none;">External Resource</div> </div> <div id="upfile'+msg+'" class="cctab-content current"> <div class="row-fluid" id="wholevideos'+msg+'"> <div class="col col-lg-8" id="allbar'+msg+'" style="display:none;"> <div class="luploadvideo-progressbar meter" ><input type="hidden" id="probar_status_'+msg+'" value="0" /><div class="bar" id="probar'+msg+'" style="width:0%"></div></div> </div> <div class="col col-lg-4"> <div class="luploadvideo" id="videosfiles-'+msg+'" style="display:none;"> <input id="luploadvideo" class="videofiles" type="file" name="lecturevideo" data-url="{!! url('courses/lecturevideo/save') !!}/'+msg+'" data-lid="'+msg+'"><span>Upload mp4/mov/avi/flv Video</span></div> <div class="luploadvideo" id="audiofiles-'+msg+'" style="display:none;"> <input id="luploadaudio" class="audiofiles luploadbtn" type="file" name="lectureaudio" data-url="{!! url('courses/lectureaudio/save') !!}/'+msg+'" data-lid="'+msg+'"> <span>Upload mp3/wav Audio</span> </div> <div class="luploadvideo" id="prefiles-'+msg+'" style="display:none;"> <input id="luploadpre" class="prefiles luploadbtn" type="file" name="lecturepre" data-url="{!! url('courses/lecturepre/save') !!}/'+msg+'" data-lid="'+msg+'"> <span>Upload PDF Presentation</span> </div> <div class="luploadvideo" id="docfiles-'+msg+'" style="display:none;"> <input id="luploaddoc" class="docfiles luploadbtn" type="file" name="lecturedoc" data-url="{!! url('courses/lecturedoc/save') !!}/'+msg+'" data-lid="'+msg+'"> <span>Upload PDF Document</span> </div> <div class="luploadvideo" id="resfiles-'+msg+'" style="display:none;"> <input id="luploaddoc" class="resfiles luploadbtn" type="file" name="lectureres" data-url="{!! url('courses/lectureres/save') !!}/'+msg+'" data-lid="'+msg+'"> <span>Upload PDF/DOCX File</span> </div> </div> <div class="col col-lg-12"> <div class="width100"  id="textdescfiles-'+msg+'" style="display:none;"> <textarea name="textdescription" id="textdesc-'+msg+'" class="form-control curricullamEditor"></textarea> <input type="button" name="textsave" value="Save"  class="btn btn-warning savedesctext" data-lid="'+msg+'"> <input type="button" name="canceldesctext" value="Cancel"  class="btn btn-warning canceldesctext" data-lid="'+msg+'"> </div> </div> <div class="clear"></div> <!-- <div class="col col-lg-12 buttongreen30"> <input type="button" class="change_media_btn" value="Change Media" onclick="deletemedia(692)"></div> --> </div> </div> <div id="fromlibrary'+msg+'" class="cctab-content"> <div class="cvideofiles" id="cvideofiles'+msg+'"> @if(isset($uservideos) && !empty($uservideos)) @foreach($uservideos as $video) <div class="cclickable updatelibcontent" id="cvideos'+msg+'_{!! $video->id !!}" data-type="video" data-alt="0" data-lib="{!! $video->id !!}" data-lid="'+msg+'"><i class="fa fa-play-circle-o"></i> {!! $video->video_name !!} ({!! $video->duration !!}) <!--div class="goright cvideodelete" data-lid="'+msg+'" data-rid="{!! $video->id !!}"><i class="goright fa fa-trash-o"></i></div--></div> @endforeach @else <center><em>Library is empty</em></center> @endif </div> <div class="caudiofiles" id="caudiofiles'+msg+'"> @if(isset($useraudios) && !empty($useraudios)) @foreach($useraudios as $audio) <div class="cclickable updatelibcontent" id="caudios'+msg+'_{!! $audio->id !!}" data-type="audio" data-alt="1" data-lib="{!! $audio->id !!}" data-lid="'+msg+'"><i class="fa fa-volume-up"></i> {!! $audio->file_title !!} ({!! $audio->duration !!}) <!--div class="goright caudiodelete" data-lid="'+msg+'" data-rid="{!! $audio->id !!}"><i class="goright fa fa-trash-o"></i></div--></div> @endforeach @else <center><em>Library is empty</em></center> @endif </div> <div class="cprefiles" id="cprefiles'+msg+'"> @if(isset($userpresentation) && !empty($userpresentation)) @foreach($userpresentation as $presentation) <div class="cclickable updatelibcontent" id="cpres'+msg+'_{!! $presentation->id !!}" data-type="presentation" data-alt="5" data-lib="{!! $presentation->id !!}" data-lid="'+msg+'"><i class="fa fa-picture-o"></i> {!! $presentation->file_title !!} ({!! ulearnHelpers::HumanFileSize($presentation->file_size) !!}) <!--div class="goright cpredelete" data-lid="'+msg+'" data-rid="{!! $presentation->id !!}"><i class="goright fa fa-trash-o"></i></div--></div> @endforeach @else <center><em>Library is empty</em></center> @endif </div><div class="cdocfiles" id="cdocfiles'+msg+'"> @if(isset($userdocuments) && !empty($userdocuments)) @foreach($userdocuments as $document) <div class="cclickable updatelibcontent" id="cdocs'+msg+'_{!! $document->id !!}" data-type="file" data-alt="2" data-lib="{!! $document->id !!}" data-lid="'+msg+'"><i class="fa fa-file-text-o"></i> {!! $document->file_title !!} ({!! ulearnHelpers::HumanFileSize($document->file_size) !!}) <!--div class="goright cdocdelete" data-lid="'+msg+'" data-rid="{!! $document->id !!}"><i class="goright fa fa-trash-o"></i></div--></div> @endforeach @else <center><em>Library is empty</em></center> @endif </div> <div class="cresfiles" id="cresfiles'+msg+'"> @if(isset($userresources) && !empty($userresources)) @foreach($userresources as $resource) <div class="cclickable updaterescontent" id="cresources'+msg+'_{!! $resource->id !!}" data-lib="{!! $resource->id !!}" data-lid="'+msg+'"><i class="fa fa-file-text"></i> {!! $resource->file_title !!} ({!! ulearnHelpers::HumanFileSize($resource->file_size) !!}) <!--div class="goright cresdelete" data-lid="'+msg+'" data-rid="{!! $resource->id !!}"><i class="goright fa fa-trash-o"></i></div--></div> @endforeach @else <center><em>Library is empty</em></center> @endif </div> </div> <div id="externalres'+msg+'" class="cctab-content"> <div class="form-group"> <label for="label" class="col-xs-12"><p><strong>Title</strong></p></label> <div class="col-xs-12"> <div><input class="form-control" placeholder="A Descriptive Title" id="exres_title'+msg+'" name="exres_title" type="text" value=""></div> </div> </div> <div class="form-group"> <label for="label" class="col-xs-12"><p><strong>Link</strong></p></label> <div class="col-xs-12"> <div><input class="form-control" placeholder="http://www.sample.com" id="exres_link'+msg+'" name="exres_link" type="text" value=""></div> </div> </div> <div class="form-group"> <div class="col-xs-12"> <div><input type="button" name="su_course_add_res_link_submit" value="Add Link" class="btn btn-warning su_course_add_res_link_submit" data-lid="'+msg+'"></div> </div> </div> </div> </div>  <div class="tips" id="videoresponse'+msg+'"> </div> <div id="resresponse'+msg+'"></div> </div></div></div></div></div>       <div class="su_course_add_lecture_desc_content su_course_add_content_desc_form hideit editing" id="adddescblock-'+msg+'"><div class="divtitlehead"><p><strong>Description</strong></p></div><div class="formrow hideit" id="descblock'+msg+'"><div class="row-fluid"><div class="editdescription" id="descriptions'+msg+'" data-lid="'+msg+'"></div></div></div><div class="formrow" id="editblock'+msg+'"><div class="row-fluid"><div class="col col-lg-12"><textarea name="lecturedescription" id="lecturedesc-'+msg+'" class="form-control curricullamEditor"></textarea></div></div></div><div class="formrow" id="editblockfooter'+msg+'"><div class="row-fluid"><div class="col col-lg-12"> <input type="button" name="su_course_add_lecture_desc_submit" value="Save" class="btn btn-warning su_course_add_lecture_desc_submit" data-lid="'+msg+'"> <input type="button" name="su_course_add_lecture_desc_cancel" value="Cancel" class="btn btn-warning su_course_add_lecture_desc_cancel" data-blockid="'+msg+'"></div></div></div></div>     <div class="su_course_add_lecture_desc_content @if(!isset($lecturesresources[$section->section_id]['+msg+'])) hideit @endif" id="resourceblock'+msg+'"> <div class="divtitlehead"><p><strong>Resources</strong></p></div> <div class="formrow"> <div class="row-fluid resourcefiles"> @if(isset($lecturesresources[$section->section_id]['+msg+'])) @foreach($lecturesresources[$section->section_id]['+msg+'] as $resources) @foreach($resources as $resource) <div id="resources'+msg+'_{!! $resource->id !!}"> @if($resource->file_type == 'link') <i class="fa fa-external-link"></i> {!! $resource->file_title !!} @else <i class="fa fa-download"></i> {!! $resource->file_title !!} ({!! ulearnHelpers::HumanFileSize($resource->file_size) !!}) @endif <div class="goright resdelete" data-lid="'+msg+'" data-rid="{!! $resource->id !!}"><i class="goright fa fa-trash-o"></i></div></div> @endforeach @endforeach @endif </div> </div> </div>     </li>');
          $( ".su_course_curriculam_sortable ul" ).sortable('refresh');
          //$('.su_course_add_lecture_content .col.col-lg-3 span').text(cno);
          $('.su_course_add_lecture_textbox').val('');
          $('.add_quiz_lecture_part').show();
          $('.su_course_add_lecture_content').hide();
          filesuploadajax();
          
          tinyMCE.execCommand('mceAddControl', false, 'textdesc-'+msg);
          tinyMCE.execCommand('mceAddControl', false, 'lecturedesc-'+msg);
        }
      });
    } else {
      $('.su_course_add_lecture_textbox').addClass('error');
      $('.su_course_add_lecture_submit').prop("disabled", false);
    }
  });

  $('.su_course_add_quiz_submit').click(function(){
    $('.su_course_add_quiz_submit').prop("disabled", true);
    if($.trim($('.su_course_add_quiz_textbox').val()).length>1) {
      var sid=$('.su_course_curriculam_sortable li.parentli').last().find('.sectionid').val();
      var sno=1;
      $( '.quiz' ).each(function(){
        sno++;
      });
      var lqno=1;
      $( '.lq_sort_quiz' ).each(function(){
        lqno++;
      });
      var stxt=$('.su_course_add_quiz_textbox').val();
      var sval=$('.su_course_add_quiz_textbox').val();
      var desc=$.trim(tinyClean(tinyMCE.get('quizdesc').getContent()));

      var courseid=$('[name="course_id"]').val();
      var coursequiz=$('[name="coursequiz"]').val();
      var _token=$('[name="_token"]').val();
      
      if(desc != ''){
        $.ajax ({
          type: "POST",
          url: coursequiz,
          data: "&courseid="+courseid+"&quiz="+stxt+"&description="+desc+"&position="+lqno+"&sectionid="+sid+"&_token="+_token,
          success: function (msg)
          {
            $('.su_course_curriculam_sortable ul').append('<li class="lq_sort_quiz su_lgray_curr quiz quiz-'+msg+' parent-s-'+sid+'"> <div class="row-fluid sorthandle"> <div class="col col-lg-12"> <div class="su_course_quiz_label su_lgray_curr_block">  <div class="edit_option edit_option_quiz">Quiz <span class="serialno">'+sno+'</span>: <label class="slqtitle">'+stxt+'</label><input type="text" maxlength="80" class="chcountfield su_course_update_quiz_textbox" value="'+stxt+'"><span class="ch-count">'+(80-stxt.length)+'</span> </div> <input type="hidden" value="'+msg+'" class="quizid" name="quizids[]"> <input type="hidden" value="'+lqno+'" class="quizpos" name="quizposition[]"> <input type="hidden" value="'+sid+'" class="quizsectionid" name="quizsectionid"> <div class="deletequiz" onclick="deletequiz('+msg+','+sid+')"></div> <div class="updatequiz" onclick="updatequiz('+msg+','+sid+')"></div> <div class="lecture_add_content" id="lecture_add_quiz'+msg+'"> <input type="button" name="lecture_add_quiz" value="Add Questions" class="addquestions" data-blockid="'+msg+'"> <div class="closeheader"> <span class="closetext"></span> <input type="button" name="lecture_close_question" value="X" class="btn-danger closequestion" data-blockid="'+msg+'"> </div> </div> </div> </div> </div> <div class="su_course_add_lecture_desc_content hideit nondata" id="questionsblock'+msg+'"> <div class="lecture_buttons lecture_edit_content"><input type="button" name="lecture_publish_content_quiz" class="btn btn-warning publishcontentquiz" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+msg+'"></div> <div class="divtitlehead"><p><strong>Questions</strong></p></div> <div class="formrow questionlist"> <div class="row-fluid quizquestions"> </div> </div> </div> <div class="lecturepopup hideit" id="quesblock-'+msg+'"> <div class="quizques"> <div class="quiz-type"> <div class="clearfix"> <div class="divli lquiz-multiple" data-lid="'+msg+'"  alt="multiple"><div class="quiztype"><span>Multiple Choice</span></div><label>Multiple Choice</label><div class="innershadowquiz"></div></div> <div class="divli lquiz-truefalse" data-lid="'+msg+'"  alt="truefalse"><div class="quiztype"><span>True / False</span></div><label>True / False</label><div class="innershadowquiz"></div></div> </div> </div> </div> </div> <div class="lecturepopup hideit" id="contentques-'+msg+'"> <div class="quizques"> <div class="divtitlehead"><p><strong>Question</strong></p></div> <div class="formrow margbot"> <div class="row-fluid"> <div><textarea name="quizquestion" id="quizquestion-'+msg+'" class="form-control curricullamEditor"></textarea></div> </div> </div> <div class="divtitlehead"><p><strong>Answers</strong></p></div> <div class="qmultiple hideit" id="multipleques-'+msg+'"> <div class="divtitlesub"><p>Write up to 5 believable options and choose the best answer.</p></div> <div class="qanswer"> <div class="col col-lg-12"> <input type="radio" name="answers-radio'+msg+'" value="1"> <input type="text" placeholder="Add an answer." class="chcountfield count600 answer" maxlength="600" name="answers[]" data-lid="'+msg+'"> <span class="answers-counter ch-count">600</span> </div> <div class="col col-lg-12"> <input type="text" placeholder="Explain why this is or isn\'t the best answer." class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]"> <span class="answers-feedback-counter ch-count">600</span> </div> </div> <div class="qanswer"> <div class="col col-lg-12"> <input type="radio" name="answers-radio'+msg+'" value="2"> <input type="text" placeholder="Add an answer." class="chcountfield count600 answer" maxlength="600" name="answers[]" data-lid="'+msg+'"> <span class="answers-counter ch-count">600</span> </div> <div class="col col-lg-12"> <input type="text" placeholder="Explain why this is or isn\'t the best answer." class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]"> <span class="answers-feedback-counter ch-count">600</span> </div> </div> <div class="qanswer"> <div class="col col-lg-12"> <div class="delques"><i class="fa fa-trash-o"></i></div> <input type="radio" name="answers-radio'+msg+'" value="3"> <input type="text" placeholder="Add an answer." class="chcountfield count600 qlastchild answer" maxlength="600" name="answers[]" data-lid="'+msg+'"> <span class="answers-counter ch-count">600</span> </div> <div class="col col-lg-12"> <input type="text" placeholder="Explain why this is or isn\'t the best answer." class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]"> <span class="answers-feedback-counter ch-count">600</span> </div> </div> </div> <div class="qtruefalse hideit" id="truefalseques-'+msg+'"> <div class="divtitlesub"><p>Check the correct answer, and click Save.</p></div> <div class="formrow"> <div class="row-fluid"> <div class="col col-lg-2"> <input type="radio" id="radtrue'+msg+'" name="answers-radio'+msg+'" value="1"> True </div> <div class="col col-lg-2"> <input type="radio" id="radfalse'+msg+'" name="answers-radio'+msg+'" value="2"> False </div> </div> </div> </div> <div class="formrow"> <div class="row-fluid"> <input type="button" name="su_course_add_quiz_question_submit" value="Save" class="btn btn-warning su_course_add_quiz_question_submit"  data-lid="'+msg+'"> <input type="hidden" value="0" id="quiztype'+msg+'"> <input type="hidden" value="0" id="coption'+msg+'"> </div> </div> </div> </div> <div class="lecturepopup hideit editquestionpart" id="editquestionpart'+msg+'"></div> <div class="su_course_add_lecture_desc_content quizeditdesc" id="quizeditdesc'+msg+'"> <div class="divtitlehead"><p><strong>Description</strong></p></div> <textarea name="lectureeditdescription" id="lectureeditdesc-'+msg+'" class="form-control curricullamEditor"></textarea> <div class="quizeditdescription" id="quizeditdescription'+msg+'">'+desc+'</div> </div> </li>');
            $( ".su_course_curriculam_sortable ul" ).sortable('refresh');
            $('.su_course_add_quiz_textbox').val('');
            $('.add_quiz_lecture_part').show();
            $('.su_course_add_quiz_content').hide();
            $('.su_course_add_quiz_submit').prop("disabled", false);
            tinyMCE.get('quizdesc').setContent('');
            
            $('input[type="radio"]').iCheck({
              checkboxClass: 'icheckbox_square-green',
              radioClass: 'iradio_square-green',
            }); 
            
            tinyMCE.execCommand('mceAddControl', false, 'quizquestion-'+msg);
            tinyMCE.execCommand('mceAddControl', false, 'lectureeditdesc-'+msg);
          }
        });
      } else {
        alert("{!! Lang::get('curriculum.curriculum_description') !!}");
        $('.su_course_add_quiz_submit').prop("disabled", false);
      } 
    } else {
      $('.su_course_add_quiz_textbox').addClass('error');
      $('.su_course_add_quiz_submit').prop("disabled", false);
    }

  });
  
  /*
  * Update course section text
  */
  $(document).on('click','.edit_option_section',function(){
    var id=$(this).next().val();
    $('.section-'+id).addClass('editon');
  });

  /*
  * Update course lecture text
  */
  $(document).on('click','.edit_option_lecture',function(){
    var id=$(this).next().val();
    $('.lecture-'+id).addClass('editon');
  });

  /*
  * Update course quiz text
  */
  $(document).on('click','.edit_option_quiz',function(){
    var id=$(this).next().val();
    if(!$('.quiz-'+id).hasClass('editon')) {
      var getdescr = $('#quizeditdescription'+id).html();
      tinyMCE.get('lectureeditdesc-'+id).setContent(getdescr);
    }
    $('.quiz-'+id).addClass('editon');
    $('#quizeditdesc'+id).show();
  });


  /*
  *   show hide for lecture and Quiz
  */

  //lecture
  
  $('.su_course_add_lecture_label').click(function(){
    $('#lecture_title_counter').text('80');
    if($('.su_course_curriculam_sortable li.parentli').length>0) {
      $('.add_quiz_lecture_part').hide();
      $('.su_course_add_lecture_content').show();
    } else {
      alert('{!! Lang::get("curriculum.section_message")!!}');
    }
  });

  $('.su_course_add_lecture_cancel').click(function(){
    $(this).parents('.su_course_add_lecture_content').hide();
    $('.add_quiz_lecture_part').show();
    $('.su_course_add_lecture_textbox').removeClass('error');
  });

  //quiz

  $('.su_course_add_quiz_label').click(function(){
    $('#quiz_title_counter').text('80');
    if($('.su_course_curriculam_sortable li.parentli').length>0) {
      $('.add_quiz_lecture_part').hide();
      $('.su_course_add_quiz_content').show();
    } else {
      alert('{!! Lang::get("curriculum.quiz_message")!!}');
    }
  });
  
  $('.su_course_add_quiz_cancel').click(function(){
    $(this).parents('.su_course_add_quiz_content').hide();
    $('.add_quiz_lecture_part').show();
    $('.su_course_add_quiz_textbox').removeClass('error');
  });  

  
  
  $(document).on('click','.resdelete',function () { 
    $(this).text('Deleting...');
    var _token=$('[name="_token"]').val();
    var lid = $(this).data('lid');
    var rid = $(this).data('rid');
    $.ajax ({
      type: "POST",
      url: $('[name="courselectureres"]').val(),
      data: "&courseid="+$('[name="course_id"]').val()+"&lid="+lid+"&rid="+rid+"&_token="+_token,
      success: function (msg)
      {
        $('#resources'+lid+'_'+rid).remove();
      }
    });
  });
  
  $(document).on('click','.addcontents',function () { 
    $(this).parent('div').children('.addcontents').hide();
    $(this).parent('div').children('.adddescription').hide();
    $(this).parent('div').children('.closeheader').children('.closecontents').show();
    $(this).parent('div').children('.closeheader').children('span.closetext').text('Select Content Type');
    $(this).parent('div').children('.closeheader').show();
    var cid = $(this).data('blockid');
    if ($('#wholeblock-'+cid).is(':visible')) { 
      $("#wholeblock-"+cid).hide(); 
    } 
    if ($("#wholeblock-"+cid).is(':visible')) { 
      $("#wholeblock-"+cid).hide();
    } else {
      $("#wholeblock-"+cid).show();
    }
    $('#contentpopshow'+cid).hide();
  });

  $(document).on('click','.closecontents',function () { 
    var cid = $(this).data('blockid');
    check_process = $('#probar_status_'+cid).val(); 
    if(check_process==1){
      alert("Please wait untill the process complete.");
      return false;
    }
    if($('#contentpopshow'+cid).hasClass('hideit')){
      $(this).parent('div').parent('div').children('.addcontents').show();
    }
    if($('#adddescblock-'+cid).hasClass('hideit')){
      $(this).parent('div').parent('div').children('.adddescription').show();
    }
    $(this).parent('div').parent('div').children('.closeheader').children('.closecontents').hide();
    $(this).parent('div').parent('div').children('.closeheader').children('span.closetext').text('');
    $(this).parent('div').parent('div').children('.closeheader').hide();
    
    if($('#adddescblock-'+cid).hasClass("hideit")) {
      $("#adddescblock-"+cid).hide();
    } else {
      $("#adddescblock-"+cid).show();
    }
    
    $("#wholeblock-"+cid).hide();
    if($('#contentpopshow'+cid).hasClass("hideit")) {
      $('#contentpopshow'+cid).hide();
      $('#videoresponse'+cid).hide();
      $('#wholevideos'+cid).show();
    } else {
      $('#contentpopshow'+cid).show();
      $('#videoresponse'+cid).show();
      $('#wholevideos'+cid).hide();
    }
    $('#cccontainer'+cid).hide();
  });

  $(document).on('click','.su_course_add_lecture_desc_cancel',function () { 
    tinyMCE.activeEditor.setContent("");
    var cid = $(this).attr('data-blockid');
    if($('#contentpopshow'+cid).hasClass('hideit')){
      $('#lecture_add_content'+cid).children('.addcontents').show();
    } 
    if($('#adddescblock-'+cid).hasClass('hideit')){
      $('#lecture_add_content'+cid).children('.adddescription').show();
    } 
    $('#lecture_add_content'+cid).children('.closeheader').children('.closecontents').hide();
    $('#lecture_add_content'+cid).children('.closeheader').children('span.closetext').text('');
    $('#lecture_add_content'+cid).children('.closeheader').hide();
    
    if($('#adddescblock-'+cid).hasClass("hideit")) {
      $("#adddescblock-"+cid).hide();
      $("#descblock-"+cid).addClass('hideit');
      $("#editblock-"+cid).removeClass('hideit');
      $("#editblockfooter-"+cid).removeClass('hideit');
    } else {
      $("#adddescblock-"+cid).removeClass('editing');
      $('#descblock'+cid).removeClass('hideit');
      $('#editblock'+cid).addClass('hideit');
      $('#editblockfooter'+cid).addClass('hideit');
    }
    
    $("#wholeblock-"+cid).hide();
    if($('#contentpopshow'+cid).hasClass("hideit")) {
      $('#contentpopshow'+cid).hide();
      $('#videoresponse'+cid).hide();
      $('#wholevideos'+cid).show();
    } else {
      $('#contentpopshow'+cid).show();
      $('#videoresponse'+cid).show();
      $('#wholevideos'+cid).hide();
    }
    $('#cccontainer'+cid).hide();
  });

  $(document).on('click','.canceldesctext',function () { 
    tinyMCE.activeEditor.setContent("");
    var cid = $(this).attr('data-lid');
    if($('#contentpopshow'+cid).hasClass('hideit')){
      $('#lecture_add_content'+cid).children('.addcontents').show();
    }
    if($('#adddescblock-'+cid).hasClass('hideit')){
      $('#lecture_add_content'+cid).children('.adddescription').show();
    }
    $('#lecture_add_content'+cid).children('.closeheader').children('.closecontents').hide();
    $('#lecture_add_content'+cid).children('.closeheader').children('span.closetext').text('');
    $('#lecture_add_content'+cid).children('.closeheader').hide();
            
    if($('#adddescblock-'+cid).hasClass("hideit")) {
      $("#adddescblock-"+cid).hide();
      $("#descblock-"+cid).removeClass('hideit');
    } else {
      $("#adddescblock-"+cid).show();
      $("#descblock-"+cid).addClass('hideit');
    }
    
    $("#wholeblock-"+cid).hide();
    if($('#contentpopshow'+cid).hasClass("hideit")) {
      $('#contentpopshow'+cid).hide();
      $('#videoresponse'+cid).hide();
      $('#wholevideos'+cid).show();
    } else {
      $('#contentpopshow'+cid).show();
      $('#videoresponse'+cid).show();
      $('#wholevideos'+cid).hide();
    }
    $('#cccontainer'+cid).hide();
  });
  
  $(document).on('click','.adddescription',function () { 
    $(this).parent('div').children('.addcontents').hide();
    $(this).parent('div').children('.adddescription').hide();
    $(this).parent('div').children('.closeheader').children('.closecontents').show();
    $(this).parent('div').children('.closeheader').children('span.closetext').text('Description');
    $(this).parent('div').children('.closeheader').show();
    var cid = $(this).data('blockid');
    $('#contentpopshow'+cid).hide();
    if ($('#adddescblock-'+cid).is(':visible')) { 
      $("#adddescblock-"+cid).hide(); 
    } 
    if ($("#adddescblock-"+cid).is(':visible')) { 
      $("#adddescblock-"+cid).hide();
    } else {
      $("#adddescblock-"+cid).show(); 

    } 
  });

  $(document).on('click','.su_course_add_lecture_desc_submit',function(){
    var lid = $(this).data('lid');
    var text = $.trim(tinyClean(tinyMCE.get('lecturedesc-'+lid).getContent()));
    if(text != '') {
      var courselecturedesc =$('[name="courselecturedesc"]').val();
      var _token =$('[name="_token"]').val();
      $.ajax ({
        type: "POST",
        url: courselecturedesc,
        data: "courseid="+$('[name="course_id"]').val()+"&lecturedescription="+text+"&lid="+lid+"&_token="+_token,
        success: function (msg)
        { 
          if($('#contentpopshow'+lid).hasClass("hideit")) {
            $('#contentpopshow'+lid).hide();
            $('#videoresponse'+lid).hide();
            $('#wholevideos'+lid).show();
            $("#lecture_add_content"+lid).find('.addcontents').show();
          } else {
            $('#contentpopshow'+lid).show();
            $('#videoresponse'+lid).show();
            $('#wholevideos'+lid).hide();
          }
          $('#descriptions'+lid).html(text);
          // $('#getdbdescription'+lid).val(text);
          $('#descblock'+lid).removeClass('hideit');
          $("#adddescblock-"+lid).removeClass('editing');
          $("#adddescblock-"+lid).removeClass('hideit');
          $('#editblock'+lid).addClass('hideit');
          $('#editblockfooter'+lid).addClass('hideit');
          $('#lecture_add_content'+lid).find('.closeheader .closecontents').hide();
          $('#lecture_add_content'+lid).find('.closeheader span.closetext').text('');
          $('#lecture_add_content'+lid).find('.closeheader').hide();
        }
      });
    } else {
      alert('{!! Lang::get("curriculum.curriculum_description") !!}');
    }
  });

  $(document).on('click','.publishcontent',function(){
    var lid = $(this).data('blockid');
    var courselecturepublish =$('[name="courselecturepublish"]').val();
    var _token =$('[name="_token"]').val();
    $(this).attr('name','lecture_unpublish_content');
    $(this).val('Unpublish');
    $(this).removeClass('publishcontent');
    $(this).addClass('unpublishcontent');
    $(this).removeClass('btn-warning');
    $(this).addClass('btn-danger');
    $.ajax ({
      type: "POST",
      url: courselecturepublish,
      data: "courseid="+$('[name="course_id"]').val()+"&publish=1&lid="+lid+"&_token="+_token,
      success: function (msg)
      {
        $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_orange_curr_block');
        $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_green_curr_block');
      }
    });
  });

  $(document).on('click','.unpublishcontent',function(){
    var lid = $(this).data('blockid');
    var courselecturepublish =$('[name="courselecturepublish"]').val();
    var _token =$('[name="_token"]').val();
    $(this).attr('name','lecture_publish_content');
    $(this).val('Publish');
    $(this).removeClass('unpublishcontent');
    $(this).addClass('publishcontent');
    $(this).removeClass('btn-danger');
    $(this).addClass('btn-warning');
    $.ajax ({
      type: "POST",
      url: courselecturepublish,
      data: "courseid="+$('[name="course_id"]').val()+"&publish=0&lid="+lid+"&_token="+_token,
      success: function (msg)
      {
        $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
      }
    });
  });

  $(document).on('click','.publishcontentquiz',function(){
    var lid = $(this).data('blockid');
    var courselecturepublish =$('[name="courselecturepublish"]').val();
    var _token =$('[name="_token"]').val();
    $(this).attr('name','lecture_unpublish_content_quiz');
    $(this).val('Unpublish');
    $(this).removeClass('publishcontentquiz');
    $(this).addClass('unpublishcontentquiz');
    $(this).removeClass('btn-warning');
    $(this).addClass('btn-danger');
    $.ajax ({
      type: "POST",
      url: courselecturepublish,
      data: "courseid="+$('[name="course_id"]').val()+"&publish=1&lid="+lid+"&_token="+_token,
      success: function (msg)
      {
        $('.quiz-'+lid).find('.su_course_quiz_label').removeClass('su_lgray_curr_block');
        $('.quiz-'+lid).find('.su_course_quiz_label').addClass('su_green_curr_block');
      }
    });
  });

  $(document).on('click','.unpublishcontentquiz',function(){
    var lid = $(this).data('blockid');
    var courselecturepublish =$('[name="courselecturepublish"]').val();
    var _token =$('[name="_token"]').val();
    $(this).attr('name','lecture_publish_content_quiz');
    $(this).val('Publish');
    $(this).removeClass('unpublishcontentquiz');
    $(this).addClass('publishcontentquiz');
    $(this).removeClass('btn-danger');
    $(this).addClass('btn-warning');
    $.ajax ({
      type: "POST",
      url: courselecturepublish,
      data: "courseid="+$('[name="course_id"]').val()+"&publish=0&lid="+lid+"&_token="+_token,
      success: function (msg)
      {
        $('.quiz-'+lid).find('.su_course_quiz_label').removeClass('su_green_curr_block');
        $('.quiz-'+lid).find('.su_course_quiz_label').addClass('su_lgray_curr_block');
      }
    });
  });

  $(document).on('click','.editdescription',function(){
    var lid = $(this).data('lid');
    var getdescr = $('#descriptions'+lid).html();
    $("#adddescblock-"+lid).addClass('editing');
    $('#descblock'+lid).addClass('hideit');
    $('#editblock'+lid).removeClass('hideit');
    $('#editblockfooter'+lid).removeClass('hideit');
    tinyMCE.get('lecturedesc-'+lid).setContent(getdescr);

  });

  $(document).on('click','.lmedia-video',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='video'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#videosfiles-'+mid).show();
      $('#audiofiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Video');
      $('#cctabs'+mid).show();
      
      $('#cccontainer'+mid).show();
      $('#upfile'+mid).addClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#cvideofiles'+mid).show();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.lmedia-audio',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='audio'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $('#audiofiles-'+mid).show();
      $('#videosfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Audio');
      $('#cctabs'+mid).show();
      
      $('#cccontainer'+mid).show();
      $('#upfile'+mid).addClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).show();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.lmedia-presentation',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='presentation'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#prefiles-'+mid).show();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Presentation');
      $('#cctabs'+mid).show();
      
      $('#cccontainer'+mid).show();
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).show();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.lmedia-file',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='file'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).show();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Document');
      $('#cctabs'+mid).show();
      
      $('#cccontainer'+mid).show();
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).show();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.lmedia-text',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='text'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#textdescfiles-'+mid).show();
      $('#allbar'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Text');
      $('#cctabs'+mid).hide();
      
      $('#cccontainer'+mid).show();
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.addresource',function(){
    var mid = $(this).data('blockid');
    var attr = $(this).data('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='resource'){
      $('#externalrestab'+mid).show();
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $("#wholevideos"+mid).show();
      $('#resfiles-'+mid).show();
      $('#videoresponse'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text("{!! Lang::get('curriculum.Add_Resource') !!}");
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#cccontainer'+mid).show();
      $('#upfile'+mid).addClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).show();
    }

  });
  

  $(document).on('click','.editlectcontent',function(){
    var mid = $(this).data('blockid');
    var attr = $(this).data('alt');
    $('#cccontainer'+mid).show();
    $('#externalrestab'+mid).removeClass('current');
    $('#externalres'+mid).removeClass('current');
    $('#fromlibrary'+mid).removeClass('current');
    $('#fromlibrarytab'+mid).removeClass('current');
    $('#upfiletab'+mid).addClass('current');
    $('#upfile'+mid).addClass('current');
    // alert(attr);
    // alert(mid);
    if(attr=='video'){
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Video');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#videosfiles-'+mid).show();
      $('#audiofiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#cctabs'+mid).show();
      
      $('#cvideofiles'+mid).show();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
      
    } else if(attr=='audio'){
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Audio');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#audiofiles-'+mid).show();
      $('#videosfiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#cctabs'+mid).show();
      
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).show();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
      
    } else if(attr=='presentation'){
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Document');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#prefiles-'+mid).show();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#cctabs'+mid).show();
      
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).show();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
      
    } else if(attr=='file'){
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Document');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).show();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#cctabs'+mid).show();
      
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).show();
      $('#cresfiles'+mid).hide();
      
    } else if(attr=='text'){
    
      var getltext = $('#lecture_contenttext'+mid).html();
      tinyMCE.get('textdesc-'+mid).setContent(getltext);
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Text');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#textdescfiles-'+mid).show();
      $('#allbar'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#cctabs'+mid).hide();
      
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });
  
  $(document).on('click','.updatelibcontent',function(){
    var lid = $(this).attr('data-lid');
    var lib = $(this).attr('data-lib');
    var alt = $(this).attr('data-alt');
    var type = $(this).attr('data-type');
    var courseselectlibrary =$('[name="courseselectlibrary"]').val();
    var _token =$('[name="_token"]').val();
    $.ajax ({
      type: "POST",
      url: courseselectlibrary,
      data: "courseid="+$('[name="course_id"]').val()+"&lid="+lid+"&lib="+lib+"&type="+alt+"&_token="+_token,
      success: function (data)
      { var return_data = $.parseJSON( data );
        if(return_data.status='true'){
          $("#contentpopshow"+lid).removeClass('hideit');
          $("#cccontainer"+lid).hide();
          $("#videoresponse"+lid).text("");
          $("#wholevideos"+lid).hide();
          $('#videoresponse'+lid).show();
          if($('#adddescblock-'+lid).hasClass('hideit')){
            $("#lecture_add_content"+lid).find('.adddescription').show();
          }
          $('#lecture_add_content'+lid).find('.closeheader .closecontents').hide();
          $('#lecture_add_content'+lid).find('.closeheader span.closetext').text('');
          $('#lecture_add_content'+lid).find('.closeheader').hide();
          $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
          $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
          $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
          if(type == 'video') {
            if(return_data.file_link == ''){
              var videopart = '{!! Lang::get("curriculum.video_message")!!}';
            } else {
              var videopart = '<video class="video-js vjs-default-skin" controls preload="auto" data-setup="{}"><source src="'+return_data.file_link+'" type="video/webm" id="videosource"></video>';
            }
            $("#videoresponse"+lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-'+type+'"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p><p><span class="cclickable vid_preview text-default" data-id="'+lid+'"><i class="fa fa-play"></i> Video Preview</span></p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+lid+'" data-alt="'+type+'"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+lid+'"></div></div><div class="media_preview" id="video_preview'+lid+'"> '+videopart+' </div></div></div>');
          } else if(type == 'audio') {
            if(return_data.file_type!='mp3'){
              var audiopart = '{!! Lang::get("curriculum.audio_message") !!}';
            } else {
              var audiopart = '<audio controls><source src="'+return_data.file_link+'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
            }
            $("#videoresponse"+lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-'+type+'"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p><p><span class="cclickable aud_preview text-default" data-id="'+lid+'"><i class="fa fa-play"></i> Audio Preview</span></p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+lid+'" data-alt="'+type+'"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+lid+'"></div></div><div class="media_preview" id="audio_preview'+lid+'">'+audiopart+'</div></div></div>');
          } else {
            $("#videoresponse"+lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-'+type+'"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+lid+'" data-alt="'+type+'"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+lid+'"></div></div></div></div>');
          }
        }else{

        }
      }
    });
  });
  
  $(document).on('click','.updaterescontent',function(){
    var lid = $(this).attr('data-lid');
    var lib = $(this).attr('data-lib');
    var file_data = $(this).text();
    var courseselectlibraryres =$('[name="courseselectlibraryres"]').val();
    var _token =$('[name="_token"]').val();
    $.ajax ({
      type: "POST",
      url: courseselectlibraryres,
      data: "courseid="+$('[name="course_id"]').val()+"&lid="+lid+"&lib="+lib+"&_token="+_token,
      success: function (data)
      { var return_data = $.parseJSON( data );
        if(return_data.status='true'){
          $("#cccontainer"+lid).hide();
          $("#resresponse"+lid).text("");
          $("#wholevideos"+lid).hide();
          $('#videoresponse'+lid).show();
          $("#lecture_add_content"+lid).find('.adddescription').hide();
          $("#lecture_add_content"+lid).find('.closecontents').show();
          $('#resourceblock'+lid).show();
          $('#resourceblock'+lid).find('.resourcefiles').append('<div id="resources'+lid+'_'+lib+'"><i class="fa fa-download"></i> '+file_data+' <div class="goright resdelete" data-lid="'+lid+'" data-rid="'+lib+'"><i class="goright fa fa-trash-o"></i></div></div>');
        }else{

        }
      }
    });
  });
  
  $(document).on('click','.su_course_add_res_link_submit',function(){
    var lid = $(this).attr('data-lid');
    var title = $('#exres_title'+lid).val();
    title = $.trim(title);
    var link = $('#exres_link'+lid).val();
    link = $.trim(link);

    //check link url validation
    if(!checkURL(link)){
      alert('invalid url format.');
      $('#exres_link'+lid).focus();
      return false;
    }

    if(title != '' && link != ''){
      $(this).attr('disabled','disabled');
      var courseexternalres =$('[name="courseexternalres"]').val();
      var _token =$('[name="_token"]').val();
      $.ajax ({
        type: "POST",
        url: courseexternalres,
        data: "courseid="+$('[name="course_id"]').val()+"&lid="+lid+"&title="+title+"&link="+link+"&_token="+_token,
        success: function (data)
        { var return_data = $.parseJSON( data );
          $('.su_course_add_res_link_submit').removeAttr('disabled');
          if(return_data.status='true'){
            $("#cccontainer"+lid).hide();
            $("#resresponse"+lid).text("");
            $("#wholevideos"+lid).hide();
            $('#videoresponse'+lid).show();
            $("#lecture_add_content"+lid).find('.adddescription').hide();
            $("#lecture_add_content"+lid).find('.closecontents').show();
            $('#resourceblock'+lid).show();
            $('#resourceblock'+lid).find('.resourcefiles').append('<div id="resources'+lid+'_'+return_data.file_id+'"><i class="fa fa-external-link"></i> '+return_data.file_title +' <div class="goright resdelete" data-lid="'+lid+'" data-rid="'+return_data.file_id+'"><i class="goright fa fa-trash-o"></i></div></div>');
            $('#exres_title'+lid).val("");
            $('#exres_link'+lid).val("");
          }else{
            
          }
        }
      });
    } else {
      alert('{!! Lang::get("curriculum.curriculum_empty")!!}');
    }
  });
  
  $(document).on('click','.vid_preview',function(){
    var lid = $(this).data('id');
    $("#video_preview"+lid).slideToggle();
  });
  
  $(document).on('click','.aud_preview',function(){
    var lid = $(this).data('id');
    $("#audio_preview"+lid).slideToggle();
  });
  
  $(document).on('click','.savedesctext',function(){
    var lid = $(this).data('lid');
    var text = $.trim(tinyClean(tinyMCE.get('textdesc-'+lid).getContent()));
    if(text != ''){
      var courselecturetext =$('[name="courselecturetext"]').val();
      var _token =$('[name="_token"]').val();
      $.ajax ({
        type: "POST",
        url: courselecturetext,
        data: "courseid="+$('[name="course_id"]').val()+"&lecturedescription="+text+"&lid="+lid+"&_token="+_token,
        success: function (data)
        { var return_data = $.parseJSON( data );
          if(return_data.status='true'){
            $("#contentpopshow"+lid).removeClass('hideit');
            $("#cccontainer"+lid).hide();
            $('#probar'+lid).css('width','0%');
            $("#videoresponse"+lid).text("");
            $("#wholevideos"+lid).hide();
            $('#videoresponse'+lid).show();
            if($('#adddescblock-'+lid).hasClass('hideit')){
              $("#lecture_add_content"+lid).find('.adddescription').show();
            } 
            $('#lecture_add_content'+lid).find('.closeheader .closecontents').hide();
            $('#lecture_add_content'+lid).find('.closeheader span.closetext').text('');
            $('#lecture_add_content'+lid).find('.closeheader').hide();
            $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
            $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
            $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
            $("#videoresponse"+lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-text"><div class="lecture_title"><p>Text</p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+lid+'" data-alt="text"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+lid+'"></div></div><div class="clearfix"></div><div class="lecture_contenttext" id="lecture_contenttext'+lid+'"><p>'+text+'</p></div></div></div>');
          }else{

          }
        }
      });
    } else {
      alert('{!! Lang::get("curriculum.curriculum_text_empty") !!}');
    }
  });
  });
  

filesuploadajax();

function filesuploadajax(){

  $('.videofiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(mp4|avi|mov|flv)$/i,
    maxFileSize: 4096000000, // 4 GB
    progress: function (e, data) {
      // console.log(data);
      
      $("#videoresponse"+data.lid).text("");
      $('#probar_status_'+data.lid).val(1);
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.video_process")!!}');
      }
    },
    processfail: function (e, data) {
      file_name = data.files[data.index].name;
      $('#probar_status_'+data.lid).val(0);
      alert("{!! Lang::get('curriculum.lecture_video_file')!!}"); 
    },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#contentpopshow"+data.lid).removeClass('hideit');
        $("#cccontainer"+data.lid).hide();
        $('#probar'+data.lid).css('width','0%');
        $("#videoresponse"+data.lid).text("");
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();
        if($('#adddescblock-'+data.lid).hasClass('hideit')){
          $("#lecture_add_content"+data.lid).find('.adddescription').show();
        } 
        $('#lecture_add_content'+data.lid).find('.closeheader .closecontents').hide();
        $('#lecture_add_content'+data.lid).find('.closeheader span.closetext').text('');
        $('#lecture_add_content'+data.lid).find('.closeheader').hide();
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        $("#videoresponse"+data.lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-video"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p><p><span class="cclickable vid_preview text-default" data-id="'+data.lid+'"><i class="fa fa-play"></i> Video Preview</span></p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+data.lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+data.lid+'" data-alt="video"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+data.lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+data.lid+'"></div></div><div class="media_preview" id="video_preview'+data.lid+'"><video class="video-js vjs-default-skin video_p_'+data.lid+'" controls="" preload="auto" data-setup="{}"></video></div></div></div>');
        $('#probar_status_'+data.lid).val(0);
        //<video class="video-js vjs-default-skin" controls preload="auto" data-setup="{}"><source src="'+return_data.file_link+'" type="video/webm" id="videosource"></video>
      }else{
        
      }

    }
  });

  $('.audiofiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(mp3|wav)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      // console.log(data);
      // alert(data.lid);
      $("#videoresponse"+data.lid).text("");
      $('#probar_status_'+data.lid).val(1);
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.audio_process")!!}');
      }
    },
    processfail: function (e, data) {
      file_name = data.files[data.index].name;
      $('#probar_status_'+data.lid).val(0);
      alert("{!! Lang::get('curriculum.lecture_audio_file')!!}");     
    },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#contentpopshow"+data.lid).removeClass('hideit');
        $("#cccontainer"+data.lid).hide();
        $('#probar'+data.lid).css('width','0%');
        $("#videoresponse"+data.lid).text("");
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();
        if($('#adddescblock-'+data.lid).hasClass('hideit')){
          $("#lecture_add_content"+data.lid).find('.adddescription').show();
        } 
        $('#lecture_add_content'+data.lid).find('.closeheader .closecontents').hide();
        $('#lecture_add_content'+data.lid).find('.closeheader span.closetext').text('');
        $('#lecture_add_content'+data.lid).find('.closeheader').hide();
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        if(return_data.file_type!='mp3'){
          var audiopart = '{!! Lang::get("curriculum.audio_message")!!}';
        } else {
          var audiopart = '<audio controls><source src="'+return_data.file_link+'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
        }
        $("#videoresponse"+data.lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-audio"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p><p><span class="cclickable aud_preview text-default" data-id="'+data.lid+'"><i class="fa fa-play"></i> Audio Preview</span></p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+data.lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+data.lid+'" data-alt="audio"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+data.lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+data.lid+'"></div></div><div class="media_preview" id="audio_preview'+data.lid+'">'+audiopart+'</div></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{
        
      }

    }
  });

  $('.prefiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(pdf)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      // console.log(data);
      // alert(data.lid);
      $("#videoresponse"+data.lid).text("");
      $('#probar_status_'+data.lid).val(1);
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.lecture_file_process")!!}');
      }
    },
    processfail: function (e, data) {
      file_name = data.files[data.index].name;
      $('#probar_status_'+data.lid).val(0);
      alert("{!! Lang::get('curriculum.lecture_pdf_file')!!}");   
    },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#contentpopshow"+data.lid).removeClass('hideit');
        $("#cccontainer"+data.lid).hide();
        $('#probar'+data.lid).css('width','0%');
        $("#videoresponse"+data.lid).text("");
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();
        if($('#adddescblock-'+data.lid).hasClass('hideit')){
          $("#lecture_add_content"+data.lid).find('.adddescription').show();
        } 
        $('#lecture_add_content'+data.lid).find('.closeheader .closecontents').hide();
        $('#lecture_add_content'+data.lid).find('.closeheader span.closetext').text('');
        $('#lecture_add_content'+data.lid).find('.closeheader').hide();
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        $("#videoresponse"+data.lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-presentation"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+data.lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+data.lid+'" data-alt="presentation"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+data.lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+data.lid+'"></div></div></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{

      }

    }
  });

  $('.docfiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(pdf)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      // console.log(data);
      // alert(data.lid);
      $('#probar_status_'+data.lid).val(1);
      $("#videoresponse"+data.lid).text("");
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.lecture_file_process")!!}');
      }
    },
    processfail: function (e, data) {
      $('#probar_status_'+data.lid).val(0);
      file_name = data.files[data.index].name;
      alert("{!! Lang::get('curriculum.lecture_pdf_file')!!}");     
    },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#contentpopshow"+data.lid).removeClass('hideit');
        $("#cccontainer"+data.lid).hide();
        $('#probar'+data.lid).css('width','0%');
        $("#videoresponse"+data.lid).text("");
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();
        if($('#adddescblock-'+data.lid).hasClass('hideit')){
          $("#lecture_add_content"+data.lid).find('.adddescription').show();
        } 
        $('#lecture_add_content'+data.lid).find('.closeheader .closecontents').hide();
        $('#lecture_add_content'+data.lid).find('.closeheader span.closetext').text('');
        $('#lecture_add_content'+data.lid).find('.closeheader').hide();
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        $("#videoresponse"+data.lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-file"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+data.lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+data.lid+'" data-alt="file"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+data.lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+data.lid+'"></div></div></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{

      }

    }
  }); 

  $('.resfiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(pdf|doc|docx)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      // console.log(data);
      // alert(data.lid);
      $('#probar_status_'+data.lid).val(1);
      $("#resresponse"+data.lid).text("");
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.lecture_file_process")!!}');
      }
    },
    processfail: function (e, data) {
      $('#probar_status_'+data.lid).val(0);
      file_name = data.files[data.index].name;
      alert("{!! Lang::get('curriculum.lecture_file_not_allowed')!!}");   
  },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#cccontainer"+data.lid).hide();
        $("#resresponse"+data.lid).text("");
        $('#probar'+data.lid).css('width','0%');
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();            
        $("#lecture_add_content"+data.lid).find('.adddescription').hide();
        $("#lecture_add_content"+data.lid).find('.closecontents').show();
        $('#resourceblock'+data.lid).show();
        $('#resourceblock'+data.lid).find('.resourcefiles').append('<div id="resources'+data.lid+'_'+return_data.file_id+'"><i class="fa fa-download"></i> '+return_data.file_title+' ('+return_data.file_size+') <div class="goright resdelete" data-lid="'+data.lid+'" data-rid="'+return_data.file_id+'"><i class="goright fa fa-trash-o"></i></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{

      }

    }
  });
}


// // Delete Course Section


function deletesection(id) {
  var _token=$('[name="_token"]').val();
  $('.section-'+id).css('opacity', '0.5');
  $.ajax ({
    type: "POST",
    url: $('[name="coursesectiondel"]').val(),
    data: "&courseid="+$('[name="course_id"]').val()+"&sid="+id+"&_token="+_token,
    success: function (msg)
    {
      
      $('.section-'+id).remove();
      $('.parent-s-'+id).remove();
      var x=1;
      $('.su_course_curriculam_sortable .su_gray_curr').each(function(){  
        $(this).find('.serialno').text(x);
        $(this).find('.sectionpos').val(x);
        x++;
      });
      updatesorting();
      //$('.su_course_add_section_content .col.col-lg-3 span').text($('.su_course_curriculam li.parentli').length+1);
    }
  });
}

// update course section

function updatesection(id) {
  $('.section-'+id).css('opacity','0.5');
  var section=$.trim($('.section-'+id+' .su_course_update_section_textbox').val());
  if(section != ''){
    if(section.length < 2)
    {
      alert('Please provide atleast 2 characters');
      return false;
    }
    var position=$('.section-'+id+' .sectionpos').val();
    var coursesection=$('[name="coursesection"]').val();
    var _token=$('[name="_token"]').val();
    $.ajax ({
      type: "POST",
      url: coursesection,
      data: "&courseid="+$('[name="course_id"]').val()+"&section="+section+"&sid="+id+"&position="+position+"&_token="+_token,
      success: function (msg)
      {
        $('.section-'+id).css('opacity','1');
        $('.section-'+id+' label.slqtitle').text(section);
        $('.section-'+id).removeClass('editon');
      }
    });
  } else {
    alert('{!! Lang::get("curriculum.curriculum_section_name") !!}');
  }
}

// Delete Course lecture

function deletelecture(id,sid) {
  var _token=$('[name="_token"]').val();
  $('.lecture-'+id).css('opacity','0.5');
  $.ajax ({
    type: "POST",
    url: $('[name="courselecturequizdel"]').val(),
    data: "&courseid="+$('[name="course_id"]').val()+"&lid="+id+"&_token="+_token,
    success: function (msg)
    {
      
      $('.lecture-'+id).remove();
      var x=1;
      $('.section-'+sid).nextUntil('.parentli', '.childli' ).each(function(){
        $(this).find('.serialno').text(x);
        x++;
      });
      var lq=1;
      $('.section-'+sid).nextUntil('.parentli', '.lq_sort' ).each(function(){
        $(this).find('.lecturepos').val(lq);
        lq++;
      });
      updatesorting();
      //$('.su_course_add_lecture_content .col.col-lg-3 span').text($('.su_course_curriculam li.childli').length+1);
    }
  });
}

// Delete Course quiz

function deletequiz(id,sid) {
  var _token=$('[name="_token"]').val();
  $('.quiz-'+id).css('opacity','0.5');
  $.ajax ({
    type: "POST",
    url: $('[name="courselecturequizdel"]').val(),
    data: "&courseid="+$('[name="course_id"]').val()+"&lid="+id+"&_token="+_token,
    success: function (msg)
    {
      
      $('.quiz-'+id).remove();
      var x=1;
      $('.section-'+sid).nextUntil('.parentli', '.quiz' ).each(function(){
        $(this).find('.serialno').text(x);
        x++;
      });
      var lq=1;
      $('.section-'+sid).nextUntil('.parentli', '.lq_sort_quiz' ).each(function(){
        $(this).find('.quizpos').val(lq);
        lq++;
      });
      updatesorting();
      //$('.su_course_add_quiz_content .col.col-lg-3 span').text($('.su_course_curriculam li.childli').length+1);
    }
  });
}

// update course lecture

function updatelecture(id,sid) {
  $('.lecture-'+id).css('opacity','0.5');
  var lecture=$.trim($('.lecture-'+id+' .su_course_update_lecture_textbox').val());
  if(lecture != ''){
    if(lecture.length<=1)
    {
      alert('{!! Lang::get("curriculum.curriculum_lecture_ch_length")!!}');
      return false;
    }

    var position=$('.lecture-'+id+' .lecturepos').val();
    var courselecture=$('[name="courselecture"]').val();
    var _token=$('[name="_token"]').val();
    $.ajax ({
      type: "POST",
      url: courselecture,
      data: "&sectionid="+sid+"&courseid="+$('[name="course_id"]').val()+"&lecture="+lecture+"&lid="+id+"&position="+position+"&_token="+_token,
      success: function (msg)
      {
        $('.lecture-'+id).css('opacity','1');
        $('.lecture-'+id+' label.slqtitle').text(lecture);
        $('.lecture-'+id).removeClass('editon');
      }
    });
  } else {
    alert('{!! Lang::get("curriculum.curriculum_lecture_name")!!}');
  }
}

function updatesorting() {
  var x=1;
  var updatesection=[];
  var updatelecturequiz=[];
  var lq=1;
  var y=1;
  var l=1;
  
  var sec_id = '';
  // Adding roll numbers for section and lectures
  $('.su_course_curriculam_sortable ul li').each(function(){
  
    if($(this).hasClass('parentli')){
      sec_id = $(this).find('.sectionid').val();
      
      $(this).find('.serialno').text(x);
      $(this).find('.sectionpos').val(x);
      var section= $(this).find('label').text();
      updatesection.push({
        section: section,
        id: sec_id,
        position: x
      });
      x++;
    } else if($(this).hasClass('childli')){
      var oldsid=$(this).find('.lecturesectionid').val();
      $(this).find('.serialno').text(y);
      $(this).find('.lecturepos').val(lq);
      $(this).find('.lecturesectionid').val(sec_id);
      
      var lid=$(this).find('.lectureid').val();
      
      $('.lecture-'+lid).removeClass('parent-s-'+oldsid);
      $('.lecture-'+lid).addClass('parent-s-'+sec_id);
      $('.lecture-'+lid+' .deletelecture').attr('onclick','deletelecture('+lid+','+sec_id+')');
      $('.lecture-'+lid+' .updatelecture').attr('onclick','updatelecture('+lid+','+sec_id+')');
      
      updatelecturequiz.push({
        sectionid: sec_id,
        id: lid,
        position: lq
      }); 
      y++;
      lq++;
    } else if($(this).hasClass('quiz')){
      var oldsid=$(this).find('.quizsectionid').val();
        
      $(this).find('.serialno').text(l);
      $(this).find('.quizpos').val(lq);
      $(this).find('.quizsectionid').val(sec_id)
      
      var lid=$(this).find('.quizid').val();

      $('.quiz-'+lid).removeClass('parent-s-'+oldsid);
      $('.quiz-'+lid).addClass('parent-s-'+sec_id);
      $('.quiz-'+lid+' .deletequiz').attr('onclick','deletequiz('+lid+','+sec_id+')');
      $('.quiz-'+lid+' .updatequiz').attr('onclick','updatequiz('+lid+','+sec_id+')');
      updatelecturequiz.push({
        sectionid: sec_id,
        id: lid,
        position: lq
      }); 
      l++;
      lq++;
    } 
  });
  
  // update the section position to db
  $.ajax ({
    type: "POST",
    url: $('[name="coursecurriculumsort"]').val(),
    data:{sectiondata: updatesection,_token:$('[name="_token"]').val(),type:'section'},
  });
  
  // update the lecture position to db
  $.ajax ({
    type: "POST",
    url: $('[name="coursecurriculumsort"]').val(),
    data:{lecturequizdata: updatelecturequiz,_token:$('[name="_token"]').val(),type:'lecturequiz'},
  });
}

function tinyClean(value) {
  value = value.replace(/&nbsp;/ig, ' ');
  value = value.replace(/\s\s+/g, ' ');
  if(value == '<p><br></p>' || value == '<p> </p>' || value == '<p></p>') {
    value = '';
  }
  return value;
}

//check url validation
function checkURL(link){
  var regexp = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return regexp.test(link); 
}

$('body').on('click','.cclickable',function(){

  if(!$(this).hasClass('updaterescontent')) 
  {
    var id = $(this).attr('data-lid');
    if(id==null)
    {
      id = $(this).attr('data-id');
    }

     $.ajax({
        url: '{!! \URL::to("courses/video") !!}',
        data:{vid:id},
        method:'POST',
        success: function(result)
        {
              var storage_path = "{{ Storage::url('/course/'.$course_id.'/') }}";
              var vi = '<source src="'+storage_path+result+'.mp4" type="video/mp4" id="videosource">';
            $('.video_p_'+id).html(vi);
          }
      });
  }
});
</script>
@endsection