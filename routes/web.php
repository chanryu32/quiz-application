<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizMaintenanceController;

Route::get('/home/{path?}', function () {
    return view('home');
})->where('path', '.*')->name('home');

Route::get('/quiz/{path?}', function () {
    return view('home');
})->where('path', '.*')->name('home');

Route::get('/quiz-management/{path?}', function () {
    return view('home');
})->where('path', '.*')->name('home');

Route::get('quizIndexAPI/', [QuizController::class, 'indexAPI'])->name('quiz.indexAPI');
Route::get('quizShowAPI/{quiz}', [QuizController::class, 'show'])->where('id', '[0-9]+')->name('quiz.show');
Route::get('quizCheckAnswerAPI/{id}/{selectedAnswer}', [QuizController::class, 'checkAnswer'])->name('quiz.checkAnswer');

Route::post('quizManagementAPI/', [QuizMaintenanceController::class, 'store'])->name('quiz-management.store');

Route::delete('quizManagementAPI/{id}', [QuizMaintenanceController::class, 'destroy'])->name('quiz-management.delete');

Route::put('quizManagementAPI/{id}', [QuizMaintenanceController::class, 'update'])->name('quiz-management.update');
