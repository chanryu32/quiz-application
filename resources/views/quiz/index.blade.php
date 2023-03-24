@extends('layouts.base')
@section('title', 'Quiz!')

@section('content')
    <div class="col mt-3 mb-5">
        <h1>Quiz!</h1>
    </div>
    <div class="row mt-5 mb-3">
        <div class="col text-right">
            <a href="{{ route('quiz-maintenance.index') }}" type="button" class="btn btn-primary">クイズ管理画面</a>
        </div>
    </div>
    <div class="row my-3">
        <table class="table table-striped table-hover table-sm" id="quizzes-table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" style="width:10%">ID</th>
                    <th scope="col">問題</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                    <tr>
                        <th scope="row">{{ $quiz->id }}</th>
                        <td>
                            <a href="{{ route('quiz.show', $quiz->id) }}">
                                {{ Str::limit($quiz->question, 60, '...') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
