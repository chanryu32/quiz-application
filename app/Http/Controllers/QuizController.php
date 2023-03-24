<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quiz.index', [
            'quizzes' => Quiz::all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('quiz.show', [
            'quiz' => Quiz::find($id)
        ]);
    }

    // クイズの正誤判定
    public function checkAnswer($id, $selectedAnswer)
    {
        $quiz = Quiz::find($id);

        $isCorrect = false;

        if ($quiz->correct_answer == $selectedAnswer) {
            $isCorrect = true;
        }

        return view('quiz.show', [
            'quiz' => Quiz::find($id),
            'isCorrect' => $isCorrect
        ]);
    }
}
