<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArchiveGradeController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CourseResultController;
use App\Http\Controllers\DetailResultController;
use App\Http\Controllers\RegisteredCourseController;
use App\Http\Controllers\InternalAnnouncementController;
use App\Http\Controllers\CourseForRegistrationController;
use App\Http\Controllers\HardCopyBookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:api']], function(){

        Route::post('/student-registration', [AuthController::class, 'studentRegistration']);
        Route::post('/teacher-registration', [AuthController::class, 'teacherRegistration']);
        Route::post('/excel-registation', [AuthController::class, 'registerStudentsFromExel']);

        Route::get('/teachers', [AuthController::class, 'teachers']);
        Route::get('/students', [AuthController::class, 'students']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::get('/{program}/{department}/{year}/student', [AuthController::class, 'getStudents']);
        Route::get('/students/download-template', [AuthController::class, 'downloadStudentTemplate']);


        Route::post('/announcements', [AnnouncementController::class, 'store']);
        Route::put('/announcements/{id}', [AnnouncementController::class, 'update']);
        Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy']);

        Route::post('/upload-book',[BookController::class, 'upload']);
        Route::get('/books',[BookController::class, 'index']);
        Route::get('/books/{id}',[BookController::class, 'show']);

        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);
        Route::post('/courses', [CourseController::class, 'store']);


        Route::get('/course-for-registration/{year}/{semester}', [CourseForRegistrationController::class, 'getCoursesForRegistration']);
        Route::post('/course-for-registration', [CourseForRegistrationController::class, 'create']);

        Route::post('/course-registration', [RegisteredCourseController::class, 'courseRegistration']);
        Route::post('/results', [DetailResultController::class, 'createDetailResult']);
        Route::get('/{student_id}/result', [CourseResultController::class, 'getResults']);
        Route::get('/archive-grades', [ArchiveGradeController::class, 'getAll']);
        Route::post('/archive-grades', [ArchiveGradeController::class, 'create']);

        Route::post('/assign-courses', [TeacherController::class , 'assignCourse']);
        Route::get('/assigned-courses', [TeacherController::class, 'getAssignedCourses']);
        Route::get('/teachers/{teacher_id}/assigned-courses', [TeacherController::class, 'getTeacherAssignedCourses']);

        Route::get('/course/{course_id}/students/{section}', [StudentController::class, 'studentsRegisteredForACourse']);
        Route::get('/{program}/{department}/courses', [CourseController::class, 'courses']);


        Route::post('/events', [EventController::class, 'store']);
        Route::put('/events/{id}', [EventController::class, 'update']);
        Route::delete('/events/{id}', [EventController::class, 'destroy']);

        Route::get('/internal-announcemets', [InternalAnnouncementController::class, 'getAnnouncemets']);
        Route::get('/internal-announcemets/{id}', [InternalAnnouncementController::class, 'getAnnouncemet']);
        Route::post('/internal-announcemets', [InternalAnnouncementController::class, 'create']);
        Route::delete('/internal-announcemets/{id}', [InternalAnnouncementController::class, 'destroy']);

        Route::get('/careers', [CareerController::class, 'getAll']);
        Route::delete('/careers/{id}', [CareerController::class, 'destroy']);

        Route::post('/hard-copy-books', [HardCopyBookController::class, 'importFromExcel']);
        Route::get('/hard-copy-books', [HardCopyBookController::class, 'getBooks']);
        Route::get('/download-template', [HardCopyBookController::class, 'downloadTemplate']);
});


Route::post('/careers', [CareerController::class, 'store']);
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/announcements/{id}', [AnnouncementController::class, 'show']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

Route::post('/login',[AuthController::class,'login']);
