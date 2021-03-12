<?php



use App\Http\Controllers\userscontroller;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\CourseController;

use App\Http\Controllers\ClasController;

use App\Http\Controllers\StudentsController;

use App\Http\Controllers\SchoolsController;

use App\Http\Controllers\InstructorsController;

use App\Http\Controllers\iconsController;

use App\Http\Controllers\SafetytipsController;

use App\Http\Controllers\DiscussionsController;

use App\Http\Controllers\DepartmentsController;

use App\Http\Controllers\SettingsController;

use App\Http\Controllers\AboutPageController;

use App\Http\Controllers\AssignmentsController;

use App\Http\Controllers\CalendarController;

use App\Http\Controllers\ContactPageController;

use App\Http\Controllers\CourseResourcesController;

use App\Http\Controllers\CourseLinkController;

use App\Http\Controllers\MessagesController;

use App\Http\Controllers\ResultsController;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\RoomsController;

use App\Http\Controllers\UserGuideController;

use App\Http\Controllers\SyllabusController;

use App\Http\Controllers\Special_educationController;

use App\Http\Controllers\Sub_adminsController;

use App\Http\Controllers\GreetingsController;

use App\Http\Controllers\QuestionsController;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\NotificationsController;

use App\Http\Controllers\QuizController;

use App\Http\Controllers\GradesController;
use App\Http\Controllers\ReportsController;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CoursegradesController;
use App\Http\Controllers\AlergiesController;

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





//Default (/) route

Route::get('/', function () {
	
    return view('users.loginpage');

});

Route::get('/get-met',function(){
    $user =     Zoom::user();
    return $user->all();
});

Route::group(['middleware' => 'auth'], function(){
	
//Dashboard Route

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/{type}', [DashboardController::class, 'index_post']);
Route::get('/noti_checker/{data}',[DashboardController::class, 'noti_checker']);
Route::get('/noti_number/{data}',[DashboardController::class, 'noti_number']);
Route::get('/noti_checker',[DashboardController::class, 'noti_checker_fetch']);
Route::post('/go_live',[DashboardController::class, 'go_live']);



//Calendar Route

Route::post('/addevent', [CalendarController::class, 'addevent']);

Route::get('/calendar', [CalendarController::class, 'index']);
Route::get('/calendar/{type}', [CalendarController::class, 'index_post']);

// Code changes for calendar add event
Route::post('/add_event_from_calendar', [CalendarController::class, 'add_event_from_calendar']);

//Assignments Routes

Route::get('/assignments/{id}', [AssignmentsController::class, 'index'])->name('Assignments');

Route::get('/assignment/create/{id}', [AssignmentsController::class, 'create']);

Route::post('/assignment/store', [AssignmentsController::class, 'store']);	

Route::get('/assignment/edit/{id}', [AssignmentsController::class, 'edit']);

Route::post('/assignment/update/{id}', [AssignmentsController::class, 'update']);

Route::get('/assignment/delete', [AssignmentsController::class, 'destroy']);


//syllabus routes

Route::get('/upload_syllabus/{id}', [SyllabusController::class, 'upload_syllabus']);

Route::post('/upload_syllabus', [SyllabusController::class, 'store_syllabus']);

Route::get('/upload_syllabus/edit/{id}', [SyllabusController::class, 'edit']);

Route::post('/upload_syllabus/update/{id}', [SyllabusController::class, 'update']);

Route::get('/deletesyllabus', [SyllabusController::class, 'destroy']);



//Quizzes routes

Route::get('/questionsweek/{insid}/{courseid}/{week}', [QuestionsController::class, 'search_by_week'])->name('week');

Route::get('/quizzes/create', [QuestionsController::class, 'create']);

Route::get('/mcq/create/{insid}/{courseid}/{week}/{qid}', [QuestionsController::class, 'mcqcreate']);

Route::get('/upload_quiz_questions/{insid}/{courseid}/{week}/{qid}', [QuestionsController::class, 'upload_quiz_questions']);

Route::post('/add_mcq_excelFile', [QuestionsController::class, 'upload_quiz_mcq']);

Route::post('/add_tf_excelFile', [QuestionsController::class, 'upload_quiz_tf']);

Route::post('/add_qa_excelFile', [QuestionsController::class, 'upload_quiz_qa']);

Route::post('/mcq/store', [QuestionsController::class, 'mcqstore']);

Route::get('/mcq/edit/{id}/{courseid}',  [QuestionsController::class, 'mcq_edit']);

Route::post('/mcq/update/{id}',  [QuestionsController::class, 'mcq_update']);

Route::get('/q/create/{insid}/{courseid}/{week}/{qid}', [QuestionsController::class, 'qcreate']);

Route::post('/q/store', [QuestionsController::class, 'qstore']);

Route::get('/q/edit/{id}/{courseid}',  [QuestionsController::class, 'q_edit']);

Route::post('/q/update/{id}',  [QuestionsController::class, 'q_update']);

Route::get('/mcq/show', [QuestionsController::class, 'see_all_mcqs']);

Route::get('/tf/show', [QuestionsController::class, 'see_all_tf']);

Route::get('/tf/create/{insid}/{courseid}/{week}/{qid}', [QuestionsController::class, 'tfcreate']);

Route::post('/tf/store', [QuestionsController::class, 'tfstore']);

Route::get('/tf/edit/{id}/{courseid}',  [QuestionsController::class, 'tf_edit']);

Route::post('/tf/update/{id}',  [QuestionsController::class, 'tf_update']);

Route::get('/filterall/{id}/{qid}', [QuestionsController::class, 'filterall']);

Route::get('/filterrecent/{id}/{qid}', [QuestionsController::class, 'filterrecent']);

Route::get('/filternotused/{id}/{qid}', [QuestionsController::class, 'filternotused']);



//Quiz Routes
Route::get('/quizzesweek/{insid}/{courseid}/{week}', [QuizController::class, 'search_by_week'])->name('week');

Route::get('/quizzes/{id}', [QuizController::class, 'index'])->name('Quizzes');

Route::get('/quiz/attempted_by/{qid}/{insid}/{cid}/{week}/{clasid}', [QuizController::class, 'attempted_by'])->name('Quizzes_attempetd_by');

Route::get('/quiz/view_solved_quiz/{stdid}/{qid}/{insid}/{cid}/{week}/{clasid}', [QuizController::class, 'view_attempted_quiz'])->name('View_attempetd_quiz');

Route::get('/quiz/create/{insid}/{courseid}/{week}/{clasid}', [QuizController::class, 'create']);

Route::get('/quiz/addquestion/toquiz/{insid}/{courseid}/{week}/{qid}/{clasid}', [QuizController::class, 'addquestion_to_quiz']);

Route::post('/quiz/addquestion/toquiz', [QuizController::class, 'storequestion_to_quiz'])->name('add.question.to.quiz');

Route::get('/quiz/showquiz/{id}', [QuizController::class, 'show_quiz'])->name('show');

Route::get('/quiz/solved_quizzes/{id}', [QuizController::class, 'show_solved_quiz']);

Route::get('/quiz/solve_quiz_result/{id}/{sid}', [QuizController::class, 'solved_quiz_result']);

Route::get('/quiz/showquiz_to_student/{id}', [QuizController::class, 'student_quizzes'])->name('quizzes');

Route::get('/course/quizzes_result/{id}/{clsid}', [QuizController::class, 'course_quizzes_result'])->name('quizzes_result');

Route::get('/quiz/solve_quiz_student/{id}/{cid}', [QuizController::class, 'show_quiz_to_student'])->name('show');

Route::get('/quiz/move_next_question/{nid}',[QuizController::class, 'move_next_question']);

Route::post('/quiz/solved_quiz_by_student', [QuizController::class, 'solved_quiz_by_student']);

Route::post('/quiz/updatequizmarks', [QuizController::class, 'update_qa_marks']);

Route::post('/quiz/create', [QuizController::class, 'store']);

Route::get('/quiz/edit/{id}/{clasid}',  [QuizController::class, 'edit']);

Route::post('/quiz/edit/{id}/{clasid}',  [QuizController::class, 'update']);

Route::get('/quiz/edit/quiz_questions/{id}',  [QuizController::class, 'edit_quiz_qiuestions']);

Route::post('/quiz/edit/quiz_questions/{id}',  [QuizController::class, 'update_quiz_qiuestions']);

Route::get('/quiz/show/{id}',  [QuizController::class, 'show']);

Route::post('/quiz/delete',  [QuizController::class, 'destroy']);

// zoom
Route::get('/zoom/show_meetings',  [DashboardController::class, 'zoom_show_meetings']);
Route::get('zoom/std/show_meetings',  [DashboardController::class, 'zoom_show_meetings_student']);





///setgrades


Route::get('/setgrades',  [GradesController::class, 'setgrades']);
Route::post('/setgrades',  [GradesController::class, 'savegrades']);
// Route::get('/editgrades',  [GradesController::class, 'editgrades']);
Route::post('/updategrades',  [GradesController::class, 'updategrades']);
// Route::get('/grade/delete', [GradesController::class, 'destroy']);



//User Guide Route

Route::get('/userguide', [UserGuideController::class, 'index']);
// Route::get('/userguide/create', [UserGuideController::class, 'create']);
Route::post('/userguide/store', [UserGuideController::class, 'store']);
Route::get('/userguide/edit/{id}', [UserGuideController::class, 'edit']);
Route::post('/userguide/update', [UserGuideController::class, 'update']);
Route::post('/userguide/delete/{id}', [UserGuideController::class, 'destroy']);

//profile

Route::get('/showprofile', [ProfileController::class, 'show_profile']);

Route::get('/editprofile', [ProfileController::class, 'edit_profile']);

Route::post('/updateprofile/{id}', [ProfileController::class, 'updateprofile']);

Route::post('/updatecontact', [ProfileController::class, 'updatecontact']);

//users crud and role

Route::get('/logout', [userscontroller::class, 'logout']);

Route::get('/forgetpassword', [userscontroller::class, 'forgetpassword']);

Route::post('/setpassword', [userscontroller::class, 'setpassword']);

Route::get('/resetpassword', [userscontroller::class, 'resetpassword']);

Route::get('/edit/{id}', [userscontroller::class, 'edit']);

Route::post('/update/{id}', [userscontroller::class, 'update']);

// Route::post('/user_session/{id}', [userscontroller::class, 'user_session']);

Route::post('/user_session/{id}',function()
{
	// $url = url()->previous();
	// // dd($url);

	// DB::table('user_loggings')->orderby('created_at','desc')->where('user_id',Auth::user()->id)->limit(1)->update([
 //            'last_active_url' => $url,
 //        ]);

	// $u = DB::table('user_loggings')->orderby('created_at','desc')->where('user_id', Auth::user()->id)->get()->first();

 //        $startTime = $u->login_at;
 //        $endTime = \Carbon\Carbon::now();
 //        $totalDuration = $endTime->diffInMinutes($startTime);

 //       if($totalDuration >= 15)
 //       {
 //       	DB::table('user_loggings')->orderby('created_at','desc')->where('user_id',Auth::user()->id)->limit(1)->update([
 //            'logout_at' => \Carbon\Carbon::now(),
 //        ]);
 //       	Auth::logout();
 //  		return redirect('/');
 //       }


});



//course crud

Route::get('/course/{cat}', [CourseController::class, 'course_wise_url']);

Route::get('/getcourses', [CourseController::class, 'get_courses']);


Route::get('/course/showdetails/{id}/{clasid}', [CourseController::class, 'show_details'])->name('Course Details');


Route::get('/course/show_week_details/{insid}/{cid}/{week}/{clasid}', [CourseController::class, 'show_week_details'])->name('Course Details');



Route::get('/course', [CourseController::class, 'course'])->name('courses');

Route::get('/studentcourses', [CourseController::class, 'students_courses']);

Route::get('/showcourseofclass/{id}', [CourseController::class, 'class_course'])->name('courses');
Route::get('/showstudentsofclass/{id}', [CourseController::class, 'class_stds'])->name('students');

Route::get('/courses', [CourseController::class, 'coursecreate']);

Route::post('/createcourse', [CourseController::class, 'coursestore']);

Route::post('/course/replicate',  [CourseController::class, 'course_replicate']);

Route::get('/course/students/{id}',  [CourseController::class, 'course_students']);

Route::get('/editgrades/{id}',  [GradesController::class, 'editgrades']);

Route::post('/updategrades/{id}',  [GradesController::class, 'updategrades']);

Route::get('/grade/delete', [GradesController::class, 'destroy']);

Route::get('/course/edit/{id}',  [CourseController::class, 'course_edit']);

Route::post('/course/update/{id}',  [CourseController::class, 'course_update']);

Route::post('/course/delete',  [CourseController::class, 'destroy']);



Route::get('/course/addinstructor/tocourse/{id}', [CourseController::class, 'addinstructor_to_course']);

Route::post('/course/addinstructor/tocourse', [CourseController::class, 'storeinstructor_to_course'])->name('add.course.to.instructor');

Route::get('/course/seeinstructors/{id}', [CourseController::class, 'see_instructors_of_course']);

Route::post('/course/destroyinstructor', [CourseController::class, 'destroy_instructor_from_course']);


Route::get('/course/addstudent/{id}/{clasid}', [CourseController::class, 'addstudent_to_course']);

Route::post('/course/addstudent', [CourseController::class, 'storestudent_to_course'])->name('add.student.to.course');

// Route::get('/course/seestudents/{id}', [CourseController::class, 'see_students_of_course']);

// ->name('add.course.to.instructor');


// dependent dropdown routes for students

Route::get('/get-instructors', [StudentsController::class, 'get_instructors']);

Route::get('/get-students', [StudentsController::class, 'get_students']);

//filter students


Route::get('/filter_recent_students/{id}', [StudentsController::class, 'filterrecent']);

//upload excel file

Route::post('/import_file_students', [StudentsController::class, 'import']);

Route::get('/add_student_sample', [StudentsController::class, 'addsample']);

Route::post('/add_student_sample', [StudentsController::class, 'storesample']);



//Attendance


Route::get('/show_student_attendance/{cid}', [AttendanceController::class, 'show_attendance_to_student']);

Route::get('/show_attendance_to_school', [AttendanceController::class, 'show_attendance_to_school']);

Route::get('/attendance_dropdown-data/{id}',[AttendanceController::class, 'data']);

Route::get('/attendance_course_dropdown-data/{id}',[AttendanceController::class, 'course_data']);

Route::get('/export_student_attendance', [AttendanceController::class, 'export']);

Route::get('/export_attendance_by_instructor', [AttendanceController::class, 'export_students']);

Route::get('/student/attendance', [AttendanceController::class, 'student_attendnace']);


//student results

Route::get('/student/results', [ResultsController::class, 'student_results']);




//Reports


Route::get('/reports/student_enrollment', [ReportsController::class, 'student_enrollment']);
Route::post('/reports/student_enrollment', [ReportsController::class, 'student_enrollment_post']);

Route::get('/reports/time_working_students_in_course', [ReportsController::class, 'time_working_students_in_course']);
Route::get('/reports/percent_assignments_completed', [ReportsController::class, 'percent_assignments_completed']);
Route::get('/reports/students_count', [ReportsController::class, 'students_count']);
Route::get('/reports/attendance', [ReportsController::class, 'attendance']);
Route::get('/reports/grade_point_average', [ReportsController::class, 'grade_point_average']);
Route::get('/reports/assignment_reporting', [ReportsController::class, 'assignment_reporting']);

Route::get('/csv_student_enrollment',[ReportsController::class, 'csv_student_enrollment']);


//students crud

Route::get('/students', [StudentsController::class, 'students'])->name('students');

Route::get('/studentcreate', [StudentsController::class, 'create']);

Route::post('/studentstore', [StudentsController::class, 'store']);

Route::get('/student/edit/{id}',  [StudentsController::class, 'edit']);

Route::get('/student/show/{id}',  [StudentsController::class, 'show']);

Route::post('/student/update/{id}',  [StudentsController::class, 'update']);

Route::post('/student/delete',  [StudentsController::class, 'destroy']);





//classes crud

Route::get('/classes', [ClasController::class, 'index'])->name('classes');

Route::get('/classcreate', [ClasController::class, 'create']);

Route::post('/classstore', [ClasController::class, 'store']);

Route::get('/class/edit/{id}',  [ClasController::class, 'edit']);

Route::get('/class/show/{id}',  [ClasController::class, 'show']);

Route::post('/class/update/{id}',  [ClasController::class, 'update']);

Route::post('/class/delete',  [ClasController::class, 'destroy']);


Route::get('/class/showinstructor/ofclass/{id}', [ClasController::class, 'show_instructors_of_class']);


Route::get('/class/addcourse/toclass/{id}', [ClasController::class, 'addcourse_to_class']);

Route::post('/class/addcourse/toclass', [ClasController::class, 'storecourse_to_class'])->name('add.course.to.class');

Route::get('/class/seeclasses/{id}', [ClasController::class, 'see_courses_of_class']);

Route::post('/class/destroycourse', [ClasController::class, 'destroy_course_from_class']);

Route::post('/class/destroystudent', [ClasController::class, 'destroy_student_from_class']);





//School crud

Route::get('/schools', [SchoolsController::class, 'schools'])->name('school');

Route::get('/change/permission/school/{id}', [SchoolsController::class, 'change_permission_school'])->name('change_school_permission');
Route::post('/change/permission/school', [SchoolsController::class, 'store_permission_school'])->name('store_school_permission');


Route::get('/change/permission/instructors/{id}', [InstructorsController::class, 'change_permission_instructor'])->name('change_permission_instructor');
Route::post('/change/permission/instructor', [InstructorsController::class, 'store_permission_ins'])->name('store_ins_permission');




Route::get('/schoolcreate', [SchoolsController::class, 'create']);

Route::post('/schoolstore', [SchoolsController::class, 'store']);

Route::get('/school/show/{id}', [SchoolsController::class, 'show']);

Route::get('/school/edit/{id}',  [SchoolsController::class, 'edit']);

Route::post('/school/update/{id}',  [SchoolsController::class, 'update']);

Route::post('/school/delete',  [SchoolsController::class, 'destroy']);

Route::get('school_grades_scale/{id}', [SchoolsController::class, 'school_grades_scale']);




//Routes for Instructors functionality:

Route::get('/instructors', [InstructorsController::class, 'index']);

Route::get('/instructors/create', [InstructorsController::class, 'create']);

Route::post('/instructors/create', [InstructorsController::class, 'store']);

Route::get('/instructors/delete', [InstructorsController::class, 'destroy']);

Route::get('/instructors/show/{id}', [InstructorsController::class, 'show']);

Route::get('/instructors/edit/{id}', [InstructorsController::class, 'edit']);

Route::POST('/instructors/edit/{id}', [InstructorsController::class, 'update']);

Route::get('/lecture/create/{insid}/{courseid}/{week}', [InstructorsController::class, 'create_lecture']);

Route::post('/lecture/create', [InstructorsController::class, 'store_lecture']);

Route::get('/lectures/{id}', [InstructorsController::class, 'show_lecture']);

Route::get('/instructor/launchmeeting/{id}/{cid}', [InstructorsController::class, 'launch_meeting']);




//Routes for safety tips functionality:

Route::get('/safetytips', [SafetytipsController::class, 'index']);

Route::get('/safetytips/create', [SafetytipsController::class, 'create']);

Route::post('/safetytips/create', [SafetytipsController::class, 'store']);

Route::get('/safetytips/delete', [SafetytipsController::class, 'destroy']);

Route::get('/safetytips/edit/{id}', [SafetytipsController::class, 'edit']);

Route::put('/safetytips/edit/{id}', [SafetytipsController::class, 'update']);





//Routes for discussions functionality:

Route::get('/discussions', [DiscussionsController::class, 'index']);

Route::get('/discussions/create', [DiscussionsController::class, 'create']);

Route::post('/discussions/create', [DiscussionsController::class, 'store']);

Route::get('/discussions/delete', [DiscussionsController::class, 'destroy']);

Route::get('/discussions/edit/{id}', [DiscussionsController::class, 'edit']);

Route::put('/discussions/edit/{id}', [DiscussionsController::class, 'update']);


//Routes for course Grades functionality:

Route::get('/coursegrades', [CoursegradesController::class, 'index']);

Route::get('/coursegrades/create', [CoursegradesController::class, 'create']);

Route::post('/coursegrades/store', [CoursegradesController::class, 'store']);

Route::post('/coursegrades/destroy', [CoursegradesController::class, 'destroy']);

Route::get('/coursegrades/edit/{id}', [CoursegradesController::class, 'edit']);

Route::put('/coursegrades/edit/{id}', [CoursegradesController::class, 'update']);


//Routes for Alergies functionality:

Route::get('/alergies', [AlergiesController::class, 'index']);

Route::get('/alergies/create', [AlergiesController::class, 'create']);

Route::post('/alergies/store', [AlergiesController::class, 'store']);

Route::post('/alergies/destroy', [AlergiesController::class, 'destroy']);

Route::get('/alergies/edit/{id}', [AlergiesController::class, 'edit']);

Route::put('/alergies/edit/{id}', [AlergiesController::class, 'update']);





//Routes for departments functionality:

Route::get('/departments', [DepartmentsController::class, 'index']);

Route::get('/departments/create', [DepartmentsController::class, 'create']);

Route::post('/departments/store', [DepartmentsController::class, 'store']);

Route::post('/departments/destroy', [DepartmentsController::class, 'destroy']);

Route::get('/departments/edit/{id}', [DepartmentsController::class, 'edit']);

Route::put('/departments/edit/{id}', [DepartmentsController::class, 'update']);

Route::get('/departments/addclass/todepartment/{id}', [DepartmentsController::class, 'addclass_to_department']);

Route::post('/departments/addclass/todepartment', [DepartmentsController::class, 'storeclass_to_department'])->name('add.depart.to.class');

Route::get('/departments/seeclasses/{id}', [DepartmentsController::class, 'see_classes_of_department']);





//Routes for rooms functionality:

Route::get('/rooms', [RoomsController::class, 'index']);

Route::get('/rooms/create', [RoomsController::class, 'create']);

Route::post('/rooms/create', [RoomsController::class, 'store']);

Route::get('/rooms/delete', [RoomsController::class, 'destroy']);

Route::get('/rooms/edit/{id}', [RoomsController::class, 'edit']);

Route::put('/rooms/edit/{id}', [RoomsController::class, 'update']);   





// icons

Route::get('/create/icon', [iconsController::class, 'iconpage']);

Route::post('/createicon', [iconsController::class, 'createicon']);

Route::get('/viewicon', [iconsController::class, 'showicon']);

Route::get('editicon/{id}',[iconsController::class,'editicon'])->name('editicon');

Route::post('updateicon/{id}',[iconsController::class,'updateicon'])->name('updateicon');

Route::get('/deleteicon/{id}', [iconsController::class,'deleteicon'])->name('/deleteicon');

// settings

Route::get('setting', [SettingsController::class, 'setting'])->name('setting');

Route::post('update',  [SettingsController::class, 'update'])->name('update');

// pages

Route::get('/aboutpage', [AboutPageController::class, 'index']);

Route::post('/updateabout/{id}',[AboutPageController::class,'update']);

Route::get('/contactpage', [ContactPageController::class, 'index']);

Route::post('/updatecontact/{id}',[ContactPageController::class,'update']);



//Routes for Course Resources functionality:

Route::get('/courseresourse/{insid}/{courseid}/{week}/{clasid}', [CourseResourcesController::class, 'index'])->name('/courseresourse');

Route::get('/courseresoursevideo/{id}', [CourseResourcesController::class, 'resourcevideo']);

Route::get('/courseresoursevideo/{insid}/{courseid}/{week}/{clasid}', [CourseResourcesController::class, 'resourcevideos']);

Route::get('/resource', [CourseResourcesController::class, 'create'])->name('/resource');

Route::get('/resources', [CourseResourcesController::class, 'resources'])->name('/resources');

Route::post('/resource/create', [CourseResourcesController::class, 'storefile']);

Route::post('/resourcevid/create', [CourseResourcesController::class, 'storevid']);

Route::get('/deleteres/{id}', [CourseResourcesController::class, 'deleteres']);

Route::get('/deletevid/{id}', [CourseResourcesController::class, 'deletevid']);

Route::get('/resource/edit/{id}/{main}', [CourseResourcesController::class, 'editfile']);

Route::get('/resource/editvid/{id}/{main}/{clasid}', [CourseResourcesController::class, 'editvid']);

Route::post('/resource/update/{id}', [CourseResourcesController::class, 'updateres'])->name('resource/update');

Route::post('/resourcevid/update', [CourseResourcesController::class, 'updatevid'])->name('resourcevid/update');

Route::get('resource/download/{id}', [CourseResourcesController::class, 'download'])->name('/download');





// Routes for Course Link:

Route::get('/linksweek/{courseid}/{week}', [CourseLinkController::class, 'search_by_week']);


Route::get('/courselink/{insid}/{courseid}/{week}', [CourseLinkController::class, 'index']);

Route::post('/linkcreate', [CourseLinkController::class, 'store']);

Route::get('/linkedit/{id}/{main}', [CourseLinkController::class, 'edit']);

Route::post('/linkupdate', [CourseLinkController::class, 'update']);

Route::get('/linkdelete/{id}', [CourseLinkController::class, 'delete']);



// Routes for Special Education:

Route::get('/special_education/index/{id}', [Special_educationController::class, 'index']);

Route::get('/special_education/create/{id}', [Special_educationController::class, 'create']);

Route::post('/special_education/store', [Special_educationController::class, 'store']);

Route::get('/special_education/show/{id}', [Special_educationController::class, 'show']);

Route::get('/special_education/edit/{id}',  [Special_educationController::class, 'edit']);

Route::post('/special_education/edit/{id}',  [Special_educationController::class, 'update']);

Route::post('/special_education/destroy', [Special_educationController::class, 'destroy']);

Route::get('/special_education/download/{id}', [Special_educationController::class, 'download'])->name('/download');

Route::get('/special_education/notification',  [Special_educationController::class, 'notify']);



// Routes for Sub Addmin:

Route::get('/Sub_admin/create', [Sub_adminsController::class, 'create']);

Route::post('/sub_admin/store', [Sub_adminsController::class, 'store']);

Route::get('/subadmin/show', [Sub_adminsController::class, 'show']);

Route::get('/subadmin/edit/{id}',  [Sub_adminsController::class, 'edit']);

Route::post('/subadmin/edit/{id}',  [Sub_adminsController::class, 'update']);

Route::post('subadmin/delete',  [Sub_adminsController::class, 'destroy']);


// Routes for Greetings:

    Route::get('/greetings/index', [GreetingsController::class, 'index']);

    Route::get('/greetings/create', [GreetingsController::class, 'create']);

    Route::post('/greetings/store', [GreetingsController::class, 'store']);
    
    Route::get('/greetings/show', [GreetingsController::class, 'index']);
    
    Route::get('/greetings/edit/{id}',  [GreetingsController::class, 'edit']);
    
    Route::post('/greetings/edit/{id}',  [GreetingsController::class, 'update']);
    
    Route::post('/greetings/destroy',  [GreetingsController::class, 'destroy']);


//messages

Route::get('/messages', [MessagesController::class, 'messages'])->name('All Message');

Route::get('/get_messages/{id}', [MessagesController::class, 'get_messages'])->name('All Message');

Route::get('/chatbox/{ins_id}', [MessagesController::class, 'messages'])->name('Send Message');

Route::post('/sendmessage', [MessagesController::class, 'sendMessage']);

});
// end of auth

Route::get('/loginpage', [userscontroller::class, 'loginpage']);

Route::post('/loginuser', [userscontroller::class, 'loginuser']);

Route::post('/registeruser', [userscontroller::class, 'registeruser']);

Route::get('/registerpage', [userscontroller::class, 'registerpage']);

Route::get('/user/loginhistory', [userscontroller::class, 'loginhistory']);


// Notifications 

Route::get('notifications',[NotificationsController::class, 'index']);
Route::get('notifications_search_bar',[NotificationsController::class, 'index']);
Route::post('notifications_search_bar',[NotificationsController::class, 'notifications_search_bar']);



//IDK

Auth::routes();