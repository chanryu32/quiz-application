<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Contracts\View\View;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('quiz.index', [
            'quizzes' => Quiz::all(),
        ]);
    }
    public function indexAPI()
    {
        $quizzes = Quiz::all();
        return response()->json($quizzes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): View
    {
        return view('quiz.show', [
            'quiz' => Quiz::find($id)
        ]);
    }

    /**
     * Summary of checkAnswer
     * @param int $id
     * @param string $selectedAnswer
     * @return View
     */
    public function checkAnswer(int $id, string $selectedAnswer): View
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
