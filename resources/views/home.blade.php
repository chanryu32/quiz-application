@extends('layouts.base')
@section('title', 'Quiz!')

@section('content')
    <div id="app">
        <router-view></router-view>
    </div>

    <!--  この中にVue本体からコンポーネントまで全て入っています -->
    <script src="{{ mix('/js/app.js') }}"></script>
@endsection
