document.addEventListener('DOMContentLoaded', () => {
    addEvent();
});

const checkClickedAnswer = (event) => {
    // addEventListenerによって反応した要素(この実装ではli要素)
    const clickedAnswerElement = event.currentTarget;
    // 選択した答え(A,B,C,D)
    const selectedAnswer = clickedAnswerElement.dataset.answer;

    // 親要素のolから、data-idの値を取得
    const questionId = clickedAnswerElement.closest('ol.answers').dataset.id;

    var url = "http://localhost/quiz/checkAnswer/id/selectedAnswer";
    url = url.replace('id', questionId).replace('selectedAnswer', selectedAnswer);

    const xhr = new XMLHttpRequest();

    // HTTPメソッドをPOSTに指定、送信するURLを指定
    xhr.open('GET', url);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-From', location.origin);
    // フォームデータを送信
    xhr.send();

    xhr.addEventListener('loadend', (event) => {
        /** @type {XMLHttpRequest} */

        // addEventListenerによってイベント検知した対象(XMLHttpRequest)のオブジェクトを取得
        const xhr = event.currentTarget;

        // http status code を確認
        if (xhr.status === 200) {
            // 正常な処理

            // サーバーからのレスポンス(LaravelのコントローラーでViewを返却)をhtmlに表示
            document.documentElement.innerHTML = xhr.response;

            addEvent();

        } else {
            // エラーなど
            alert('Error:回答データの取得に失敗しました。');
        }
    });
};

const addEvent = () => {

    // 解答の選択肢一覧を取得
    const answersList = document.querySelectorAll('ol.answers li');
    // クリックされたときの処理を仕込む
    answersList.forEach(li => li.addEventListener('click', checkClickedAnswer));
};