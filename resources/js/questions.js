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

    axios.get(`/quiz/checkAnswer/${questionId}/${selectedAnswer}`)
        .then((response) => {
            // サーバーからのレスポンス(LaravelのコントローラーでViewを返却)をhtmlに表示
            document.documentElement.innerHTML = response.data;

            addEvent();
            console.log(response);
        })
        .catch((error) => {
            // リクエストで何らかのエラーが発生した場合
            alert(error);
            console.log(error);
        });
};

const addEvent = () => {

    // 解答の選択肢一覧を取得
    const answersList = document.querySelectorAll('ol.answers li');
    // クリックされたときの処理を仕込む
    answersList.forEach(li => li.addEventListener('click', checkClickedAnswer));
};