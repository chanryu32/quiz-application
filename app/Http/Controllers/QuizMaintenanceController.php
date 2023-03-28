<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Log;

class QuizMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::all();
        return response()->json($quizzes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 入力内容のチェック
        // ルールに一致しない入力の場合は、自動的に入力画面を表示させる
        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'answer_a' => 'required|max:255',
            'answer_b' => 'required|max:255',
            'answer_c' => 'required|max:255',
            'answer_d' => 'required|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'max:65535',
        ]);

        // Modelを作成
        $Quiz = new Quiz;
        $Quiz->question = $validatedData['question'];
        $Quiz->answer_a = $validatedData['answer_a'];
        $Quiz->answer_b = $validatedData['answer_b'];
        $Quiz->answer_c = $validatedData['answer_c'];
        $Quiz->answer_d = $validatedData['answer_d'];
        $Quiz->correct_answer = $validatedData['correct_answer'];
        $Quiz->explanation = $validatedData['explanation'];

        // ModelをDBに保存
        $Quiz->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, int $id)
    {

        // 入力内容のチェック
        // ルールに一致しない入力の場合は、自動的に入力画面を表示させる
        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'answer_a' => 'required|max:255',
            'answer_b' => 'required|max:255',
            'answer_c' => 'required|max:255',
            'answer_d' => 'required|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'max:65535',
        ]);

        // Modelを作成
        $Quiz = Quiz::find($id);
        $Quiz->question = $validatedData['question'];
        $Quiz->answer_a = $validatedData['answer_a'];
        $Quiz->answer_b = $validatedData['answer_b'];
        $Quiz->answer_c = $validatedData['answer_c'];
        $Quiz->answer_d = $validatedData['answer_d'];
        $Quiz->correct_answer = $validatedData['correct_answer'];
        $Quiz->explanation = $validatedData['explanation'];

        // ModelをDBに保存
        $Quiz->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if (!Quiz::destroy($id)) {
            // 400 Bad Request
            return new JsonResponse([
                'message' => 'Failed to delete.',
            ], 400);
        }

        // 204 NO CONTENT
        return response()->json(null, 204);
    }
}
