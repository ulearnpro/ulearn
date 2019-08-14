<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeController@index')->name('home');
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logOut');

Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('about', 'HomeController@pageAbout')->name('page.about');
Route::get('contact', 'HomeController@pageContact')->name('page.contact');
Route::get('instructor/{instructor_slug}', 'InstructorController@instructorView')->name('instructor.view');

Route::get('getCheckTime', 'HomeController@getCheckTime');

Route::get('checkUserEmailExists', 'HomeController@checkUserEmailExists');

Route::get('checkUserEmailExists', 'HomeController@checkUserEmailExists');

Route::get('course-view/{course_slug}', 'CourseController@courseView')->name('course.view');
Route::get('courses', 'CourseController@courseList')->name('course.list');
Route::get('checkout/{course_slug}', 'CourseController@checkout')->name('course.checkout');
Route::get('course-breadcrumb', 'CourseController@saveBreadcrumb')->name('course.breadcurmb');

Route::post('become-instructor', 'InstructorController@becomeInstructor')->name('become.instructor');

Route::get('instructors', 'InstructorController@instructorList')->name('instructor.list');
Route::post('contact-instructor', 'InstructorController@contactInstructor')->name('contact.instructor');

Route::post('contact-admin', 'HomeController@contactAdmin')->name('contact.admin');

Route::get('blogs', 'HomeController@blogList')->name('blogs');
Route::get('blog/{blog_slug}', 'HomeController@blogView')->name('blog.view');

//Functions accessed by only authenticated users
Route::group(['middleware' => 'auth'], function () {

    Route::post('delete-photo', 'CourseController@deletePhoto');
    Route::post('payment-form', 'PaymentController@paymentForm')->name('payment.form');

    Route::get('payment/success', 'PaymentController@getSuccess')->name('payment.success');
    Route::get('payment/failure', 'PaymentController@getFailure')->name('payment.failure');



    //Functions accessed by only students
    Route::group(['middleware' => 'role:student'], function () {

        Route::get('course-enroll-api/{course_slug}/{lecture_slug}/{is_sidebar}', 'CourseController@courseEnrollAPI');
        Route::get('readPDF/{file_id}', 'CourseController@readPDF');
        Route::get('update-lecture-status/{course_id}/{lecture_id}/{status}', 'CourseController@updateLectureStatus');

        Route::get('download-resource/{resource_id}/{course_slug}', 'CourseController@getDownloadResource');

        Route::get('my-courses', 'CourseController@myCourses')->name('my.courses');
        Route::get('course-learn/{course_slug}', 'CourseController@courseLearn')->name('course.learn');

        Route::post('course-rate', 'CourseController@courseRate')->name('course.rate');
        Route::get('delete-rating/{raing_id}', 'CourseController@deleteRating')->name('delete.rating');

        Route::get('course-enroll-api/{course_slug}/{lecture_slug}/{is_sidebar}', 'CourseController@courseEnrollAPI');
        Route::get('readPDF/{file_id}', 'CourseController@readPDF');

    });

    //Functions accessed by both student and instructor
    // Route::group(['middleware' => 'role:student,instructor'], function () {
    Route::group(['middleware' => 'role:instructor'], function () {
        Route::get('instructor-dashboard', 'InstructorController@dashboard')->name('instructor.dashboard');

        Route::get('instructor-profile', 'InstructorController@getProfile')->name('instructor.profile.get');
        Route::post('instructor-profile', 'InstructorController@saveProfile')->name('instructor.profile.save');

        Route::get('course-create', 'CourseController@createInfo')->name('instructor.course.create');
        Route::get('instructor-course-list', 'CourseController@instructorCourseList')->name('instructor.course.list');
        Route::get('instructor-course-info', 'CourseController@instructorCourseInfo')->name('instructor.course.info');
        Route::get('instructor-course-info/{course_id}', 'CourseController@instructorCourseInfo')->name('instructor.course.info.edit');
        Route::post('instructor-course-info-save', 'CourseController@instructorCourseInfoSave')->name('instructor.course.info.save');

        Route::get('instructor-course-image', 'CourseController@instructorCourseImage')->name('instructor.course.image');
        Route::get('instructor-course-image/{course_id}', 'CourseController@instructorCourseImage')->name('instructor.course.image.edit');
        Route::post('instructor-course-image-save', 'CourseController@instructorCourseImageSave')->name('instructor.course.image.save');

        Route::get('instructor-course-video/{course_id}', 'CourseController@instructorCourseVideo')->name('instructor.course.video.edit');
        Route::post('instructor-course-video-save', 'CourseController@instructorCourseVideoSave')->name('instructor.course.video.save');

        Route::get('instructor-course-curriculum/{course_id}', 'CourseController@instructorCourseCurriculum')->name('instructor.course.curriculum.edit');
        Route::post('instructor-course-curriculum-save', 'CourseController@instructorCourseCurriculumSave')->name('instructor.course.curriculum.save');


        Route::get('instructor-credits', 'InstructorController@credits')->name('instructor.credits');

        Route::post('instructor-withdraw-request', 'InstructorController@withdrawRequest')->name('instructor.withdraw.request');

        Route::get('instructor-withdraw-requests', 'InstructorController@listWithdrawRequests')->name('instructor.list.withdraw');

        // Save Curriculum
        Route::post('courses/section/save', 'CourseController@postSectionSave');
        Route::post('courses/section/delete', 'CourseController@postSectionDelete');
        Route::post('courses/lecture/save', 'CourseController@postLectureSave');
        Route::post('courses/video', 'CourseController@postVideo');
        
        Route::post('courses/lecturequiz/delete', 'CourseController@postLectureQuizDelete');
        Route::post('courses/lecturedesc/save', 'CourseController@postLectureDescSave');
        Route::post('courses/lecturepublish/save', 'CourseController@postLecturePublishSave');
        Route::post('courses/lecturevideo/save/{lid}', 'CourseController@postLectureVideoSave');
        Route::post('courses/lectureaudio/save/{lid}', 'CourseController@postLectureAudioSave');
        Route::post('courses/lecturepre/save/{lid}', 'CourseController@postLecturePresentationSave');
        Route::post('courses/lecturedoc/save/{lid}', 'CourseController@postLectureDocumentSave');
        Route::post('courses/lectureres/save/{lid}', 'CourseController@postLectureResourceSave');
        Route::post('courses/lecturetext/save', 'CourseController@postLectureTextSave');
        Route::post('courses/lectureres/delete', 'CourseController@postLectureResourceDelete');
        Route::post('courses/lecturelib/save', 'CourseController@postLectureLibrarySave');
        Route::post('courses/lecturelibres/save', 'CourseController@postLectureLibraryResourceSave');
        Route::post('courses/lectureexres/save', 'CourseController@postLectureExternalResourceSave');
        
        // Sorting Curriculum
        Route::post('courses/curriculum/sort', 'CourseController@postCurriculumSort');
    });

    
    //Functions accessed by only admin users
    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('admin/dashboard', 'Admin\DashboardController')->name('admin.dashboard');
        
        Route::get('admin/users', 'Admin\UserController@index')->name('admin.users');
        Route::get('admin/user-form', 'Admin\UserController@getForm')->name('admin.getForm');
        Route::get('admin/user-form/{user_id}', 'Admin\UserController@getForm');
        Route::post('admin/save-user', 'Admin\UserController@saveUser')->name('admin.saveUser');
        Route::get('admin/users/getData', 'Admin\UserController@getData')->name('admin.users.getData');

        Route::get('admin/categories', 'Admin\CategoryController@index')->name('admin.categories');
        Route::get('admin/category-form', 'Admin\CategoryController@getForm')->name('admin.categoryForm');
        Route::get('admin/category-form/{Category_id}', 'Admin\CategoryController@getForm');
        Route::post('admin/save-category', 'Admin\CategoryController@saveCategory')->name('admin.saveCategory');
        Route::get('admin/delete-category/{Category_id}', 'Admin\CategoryController@deleteCategory');

        Route::get('admin/blogs', 'Admin\BlogController@index')->name('admin.blogs');
        Route::get('admin/blog-form', 'Admin\BlogController@getForm')->name('admin.blogForm');
        Route::get('admin/blog-form/{blog_id}', 'Admin\BlogController@getForm');
        Route::post('admin/save-blog', 'Admin\BlogController@saveBlog')->name('admin.saveBlog');
        Route::get('admin/delete-blog/{blog_id}', 'Admin\BlogController@deleteBlog');

        Route::get('admin/withdraw-requests', 'Admin\DashboardController@withdrawRequests')->name('admin.withdraw.requests');
        Route::get('admin/approve-withdraw-request/{request_id}', 'Admin\DashboardController@approveWithdrawRequest')->name('admin.approve.withdraw.request');

        Route::post('admin/config/save-config', 'Admin\ConfigController@saveConfig')->name('admin.saveConfig');
        Route::get('admin/config/page-home', 'Admin\ConfigController@pageHome')->name('admin.pageHome');
        Route::get('admin/config/page-about', 'Admin\ConfigController@pageAbout')->name('admin.pageAbout');
        Route::get('admin/config/page-contact', 'Admin\ConfigController@pageContact')->name('admin.pageContact');

        Route::get('admin/config/setting-general', 'Admin\ConfigController@settingGeneral')->name('admin.settingGeneral');
        Route::get('admin/config/setting-payment', 'Admin\ConfigController@settingPayment')->name('admin.settingPayment');
        Route::get('admin/config/setting-email', 'Admin\ConfigController@settingEmail')->name('admin.settingEmail');
    });

    Route::group(['middleware' => 'subscribed'], function () {
        //Route for react js
        Route::get('course-enroll/{course_slug}/{lecture_slug}', function () {
            return view('site/course/course_enroll');
        });
        Route::get('course-learn/{course_slug}', 'CourseController@courseLearn')->name('course.learn');
    });
    
});