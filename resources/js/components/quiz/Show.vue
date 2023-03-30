<template>
  <h1>Quiz!</h1>
  <div v-if="!this.quiz" class="col mt-3 mb-5">
    <span>問題が見つかりませんでした</span>
  </div>
  <div v-slse class="col mt-3 mb-5">
    <h2>問題</h2>
    <div class="pl-2">
      <div class="mt-1">
        <p v-html="formatText(quiz.question)"></p>
      </div>
    </div>
  </div>
  <div class="col mt-3 mb-5">
    <h2>選択肢</h2>
    <div class="mt-1">
      <ol class="pl-4 answers" style="list-style-type: upper-alpha">
        <li @click="checkClickedAnswer('A')">{{ quiz.answer_a }}</li>
        <li @click="checkClickedAnswer('B')">{{ quiz.answer_b }}</li>
        <li @click="checkClickedAnswer('C')">{{ quiz.answer_c }}</li>
        <li @click="checkClickedAnswer('D')">{{ quiz.answer_d }}</li>
      </ol>
    </div>
  </div>
  <div v-if="isCorrect !== null">
    <h3>
      <div :id="isCorrect ? 'correct' : 'unCorrect'">
        {{ isCorrect ? "正解です！" : "不正解です！" }}
      </div>
    </h3>
    <div class="pl-2" id="answer">
      <span>正解: {{ quiz.correct_answer }}</span>
    </div>
    <h4>
      <div class="pl-2 mt-2" id="explanation">
        解説:
        <p v-html="formatText(quiz.explanation)"></p>
      </div>
    </h4>
  </div>
  <div class="mt-3 mb-5 text-right">
    <router-link to="/quiz" class="btn btn-link">問題一覧に戻る!</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      quiz: Object,
      isCorrect: null,
    };
  },
  created() {
    this.fetchQuiz(this.$route.params.id);
  },
  methods: {
    checkClickedAnswer(answer) {
      // 選択した答え(A,B,C,D)
      const selectedAnswer = answer;
      const questionId = this.$route.params.id;

      axios
        .get(`/quizCheckAnswerAPI/${questionId}/${selectedAnswer}`)
        .then((response) => {
          this.isCorrect = response.data;

          console.log(response);
        })
        .catch((error) => {
          // リクエストで何らかのエラーが発生した場合
          alert(error);
          console.log(error);
        });
    },
    fetchQuiz(id) {
      axios
        .get("/quizShowAPI/" + id)
        .then((response) => {
          this.quiz = response.data;

          console.log(response);
        })
        .catch((error) => {
          // リクエストで何らかのエラーが発生した場合
          alert(error);
          console.log(error);
        });
    },
    formatText(text) {
      return text.replace(/\s/g, "<br>");
    },
  },
};
</script>
<style>
/*
 * 単位について
 * 1px = 1ドット分(ディスプレイの一つの点の分)
 * 1em = 親要素のフォントサイズと同じ = 通常16px
 */

/* 
 * <h2>タグにスタイルを適用
 */
h2 {
  /* 線を描画 (solid:1本線, #1e366a: 16進数カラーコード, 1px: 文字の太さ */
  border-bottom: solid #1e366a 1px;
}

/*
 * <ul>タグにスタイルを適用
 */
ul {
  /* 要素の内側（境界線からコンテンツ本体の間)の領域。左のみを調整 */
  padding-left: 0.5em;
}

/* 
 * class="answers"が指定されているタグの部分にスタイルを適用
 * ※classは複数の要素に指定することができる(class="answers"は複数のタグに指定できる)
 */
ol.answers {
  /* リストの先頭の表示を指定 */
  list-style: upper-alpha;

  padding: 0 1em;
}

/*
 * <ul>の中にある<li>タグにスタイルを適用
 * (タグ名とタグ名をスペースで指定すると、左に記述したタグの子どものタグを指定することになる）
 */
ul li,
ol li {
  /* 要素の内側（境界線からコンテンツ本体の間)の領域。2つ指定しているときは左から 上下 左右 の順番で値が指定される(※em指定することでブラウザの拡大、縮小で1emが変化する) */
  padding: 1em;
  list-style-position: inside;
}

/*
 * リストにマウスをおいたときだけスタイルが変わる
 */
ol.answers li:hover {
  border: solid #1e366a 0.1em;
  padding: 0.9em;
  background-color: #e5ecfc;
  /* マウスのポインタを変化させる */
  cursor: pointer;
}

/**
 * <span>タグのid=correct-answerが指定されているところだけスタイルを適用する
 */
span#correct-answer {
  /* 文字の太さを指定 */
  font-weight: bold;
}

/* 
 * id="main"が指定されているタグの部分にスタイルを適用
 * ※idは複数の要素に指定することはできない(id="main"が指定されているのは一つのHTMLで一つのみ)
 * ※要素名は省略できるがdiv#mainと書くこともできる
 */
#main {
  /* 要素の内側（境界線からコンテンツ本体の間)の領域を指定(上下, 左右) */
  padding: 0 1.5em;
}

/*
 * class="section"が指定されているタグの部分にスタイルを適用
 * ※classは複数の要素に指定することができる
 * ※要素名は省略して.sectionと書くこともできる
 * (その場合、class指定されている要素すべてにスタイルが適用される)
 */
div.section {
  /* 上の余白を指定 */
  margin-top: 2em;
}

div#section-correct-answer {
  /** 表示しない */
  display: none;
}
</style>
