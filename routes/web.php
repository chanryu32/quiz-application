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


Route::get('quiz/indexAPI', [QuizController::class, 'indexAPI'])->name('quiz.indexAPI');
Route::get('quiz/{quiz}', [QuizController::class, 'show'])->where('id', '[0-9]+')->name('quiz.show');
//クイズプレイ用ルーティング
Route::resource('quiz', QuizController::class);

//クイズ管理用ルーティング
Route::resource('quiz-maintenance', QuizMaintenanceController::class);

Route::get('quiz/checkAnswer/{id}/{selectedAnswer}', [QuizController::class, 'checkAnswer'])->name('quiz.checkAnswer');
