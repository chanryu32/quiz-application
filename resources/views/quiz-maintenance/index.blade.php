@extends('layouts.base')
@section('title', 'Quiz 管理')

@section('content')
    <div class="col mt-3 mb-5">
        <h1>Quiz 管理</h1>
    </div>
    <div class="row mt-5 mb-3">

        <div class="col text-right">
            <a href="{{ route('quiz.index') }}" type="button" class="btn btn-primary">クイズをプレイ！</a>
            <a href="{{ route('quiz-maintenance.create') }}" type="button" class="btn btn-primary">追加</a>
        </div>
    </div>
    <div class="row my-3">
        <table class="table table-striped table-hover table-sm" id="quizzes-table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" style="width:10%">ID</th>
                    <th scope="col">問題</th>
                    <th scope="col" style="width:11%">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                    <tr>
                        <th scope="row">{{ $quiz->id }}</th>
                        <td>
                            <a href="{{ route('quiz-maintenance.show', $quiz->id) }}">
                                {{ Str::limit($quiz->question, 60, '...') }}
                            </a>
                        </td>
                        <td>
                            <div style="display:flex; justify-content:space-between;">
                                <a href="{{ route('quiz-maintenance.edit', $quiz->id) }}" type="button"
                                    class="btn btn-outline-primary btn-sm">編集</a>
                                <button type="button" class="delete-quiz btn btn-outline-danger btn-sm"
                                    data-id="{{ $quiz->id }}">削除
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
