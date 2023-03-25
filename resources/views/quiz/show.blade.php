@extends('layouts.base')
@section('title', 'Quiz!')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <h1>Quiz!</h1>
    @if (empty($quiz))
        <div class="col mt-3 mb-5">
            <span>問題が見つかりませんでした</span>
        </div>
    @else
        @csrf
        <div class="col mt-3 mb-5">
            <h2>問題</h2>
            <div class="pl-2">
                <div class="mt-1">
                    <p>{!! nl2br(e($quiz->question)) !!}</p>
                </div>
            </div>
        </div>
        <div class="col mt-3 mb-5">
            <h2>選択肢</h2>
            <div class="mt-1">
                <ol class="pl-4 answers" data-id="{{ $quiz->id }}" style="list-style-type: upper-alpha">
                    <li data-answer='A'>{{ $quiz->answer_a }}</li>
                    <li data-answer='B'>{{ $quiz->answer_b }}</li>
                    <li data-answer='C'>{{ $quiz->answer_c }}</li>
                    <li data-answer='D'>{{ $quiz->answer_d }}</li>
                </ol>
            </div>
            @if (isset($isCorrect))
                <h3>
                    @if ($isCorrect)
                        <div id="correct">正解です！</div>
                    @else
                        <div id="unCorrect">不正解です！</div>
                    @endif
                </h3>
                <div class="pl-2" id="answer">
                    <span>正解: {{ $quiz->correct_answer }}</span>
                </div>
                <h4>
                    <div class="pl-2 mt-2" id="explanation">
                        <p>
                            解説:{!! nl2br(e($quiz->explanation)) !!}
                        </p>
                    </div>
                </h4>
            @endif
        </div>
    @endif
    <div class="mt-3 mb-5 text-center">
        <a href="{{ route('quiz.index') }}" type="button" class="btn btn-link">問題一覧に戻る</a>
    </div>
@endsection
