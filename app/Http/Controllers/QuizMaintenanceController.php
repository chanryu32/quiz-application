<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class QuizMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('quiz-maintenance.index', [
            'quizzes' => Quiz::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('quiz-maintenance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
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

        // 一覧ページを表示
        // ※ リロードされたときに、もう一度データが保存されないようにリダイレクトさせる
        return redirect()->route('quiz-maintenance.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): View
    {
        return view('quiz-maintenance.show', [
            'quiz' => Quiz::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        return view('quiz-maintenance.edit', ['quiz' => Quiz::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
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

        // 一覧ページを表示
        // ※ リロードされたときに、もう一度データが保存されないようにリダイレクトさせる
        return redirect(route('quiz-maintenance.index'));
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
