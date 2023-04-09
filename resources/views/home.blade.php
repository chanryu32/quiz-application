<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Quiz!</title>
</head>

<body>
    <div class="container">
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
        <script src="{{ mix('/js/Quiz.js') }}"></script>
    </div>
</body>

</html>
