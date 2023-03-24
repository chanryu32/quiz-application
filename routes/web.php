<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizMaintenanceController;

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

Route::get('/', function () {
    return view('welcome');
});

//クイズプレイ用ルーティング
Route::resource('quiz', QuizController::class);

//クイズ管理用ルーティング
Route::resource('quiz-maintenance', QuizMaintenanceController::class);

Route::get('quiz/checkAnswer/{id}/{selectedAnswer}', [QuizController::class, 'checkAnswer'])->name('quiz.checkAnswer');
