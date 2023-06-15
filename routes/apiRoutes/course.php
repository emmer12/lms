<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\MaterialController;

Route::get('/course-all', [CourseController::class, 'index']);
Route::get('/course-all/{slug}', [CourseController::class, 'showBySlug']);



Route::middleware(['auth:sanctum', 'apply_locale'])->group(
    function () {
        Route::get('/admin/course-all', [CourseController::class, 'getAll']);
        Route::get('/course-my', [CourseController::class, 'myCourses']);
        Route::get('/course/download-certificate/{course}', [CourseController::class, 'certificate']);
        Route::get('/course-lessons/{course}', [CourseController::class, 'courseLessons']);
        Route::resource('course', CourseController::class);
        Route::get('course/lessons/{lesson}', [LessonController::class, 'show']);
        Route::get('course/{course}/lessons', [LessonController::class, 'index']);
        Route::post('course/{course}/lessons', [LessonController::class, 'store']);
        Route::patch('course/{course}/lessons', [LessonController::class, 'update']);
        Route::delete('course/lessons/{course}', [LessonController::class, 'destroy']);
        Route::get('course/lessons/form-data', [LessonController::class, 'formData']);
        Route::post('course/enroll', [EnrollmentController::class, 'store']);
        // Quiz 
        Route::get('course/{lesson}/questions', [QuizController::class, 'questions']);
        Route::post('course/{lesson}/questions', [QuizController::class, 'storeQuestion']);
        Route::patch('course/{question}/question', [QuizController::class, 'update']);
        Route::delete('course/question/{question}', [QuizController::class, 'delete']);

        // Material
        Route::get('course/{lesson}/materials', [MaterialController::class, 'materials']);
        Route::post('course/{lesson}/materials', [MaterialController::class, 'storeMaterial']);
        Route::patch('course/{material}/question', [MaterialController::class, 'update']);
        Route::delete('course/material/{material}', [MaterialController::class, 'delete']);

        Route::post('course/quiz/start', [QuizController::class, 'start']);
        Route::post('course/quiz/restart', [QuizController::class, 'reStart']);
        Route::post('course/quiz/submit', [QuizController::class, 'submit']);
        Route::get('course/quiz/{lesson_id}', [QuizController::class, 'getLQuiz']);

        Route::patch('course/lesson/completed/{lesson}', [LessonController::class, 'completed']);
    }
);
