@extends('layouts.base')
@section('title', 'Quiz!')

@section('content')
    <div id="app">
        <v-index></v-index>
    </div>

    <!--  この中にVue本体からコンポーネントまで全て入っています -->
    <script src="{{ mix('/js/app.js') }}"></script>

    <script>
        createApp({
                // 省略
            })
            .component('v-index', IndexComponent) //  ここでセットしています
            .mount('#app');
    </script>

@endsection
