<template>
  <div>
    <h1>Quiz 管理 - 問題の内容</h1>
    <div v-if="quiz === null" class="col mt-3 mb-5">
      <span>問題が見つかりませんでした</span>
    </div>
    <div v-else class="col mt-3 mb-5">
      <h2>問題</h2>
      <div class="pl-2">
        <div class="mt-1">
          <p v-html="formatText(quiz.question)"></p>
        </div>
        <div class="mt-1">
          <ol class="pl-4" style="list-style-type: upper-alpha">
            <li>{{ quiz.answer_a }}</li>
            <li>{{ quiz.answer_b }}</li>
            <li>{{ quiz.answer_c }}</li>
            <li>{{ quiz.answer_d }}</li>
          </ol>
        </div>
      </div>
    </div>
    <div v-if="quiz !== null" class="col mt-3 mb-5">
      <h2>答え</h2>
      <div class="pl-2">
        <span>選択肢: {{ quiz.correct_answer }}</span>
        <p v-html="formatText(quiz.explanation)"></p>
      </div>
    </div>
    <div class="mt-3 mb-5 text-center">
      <router-link to="/quiz-management" class="btn btn-link">
        一覧に戻る
      </router-link>
    </div>
  </div>
  <div v-if="isLoading" class="spinner"></div>
  <div v-if="error" class="error-container">{{ error }}</div>
</template>

<script>
export default {
  data() {
    return {
      quiz: null,
      error: null,
      isLoading: false,
    };
  },
  created() {
    this.fetchQuiz(this.$route.params.id);
  },
  beforeUnmount() {
    this.cancelRequest();
  },
  methods: {
    fetchQuiz(id) {
      this.isLoading = true;
      axios
        .get(`/quizShowAPI/${this.$route.params.id}`, {
          cancelToken: new axios.CancelToken((c) => {
            this.cancelRequest = c;
          }),
        })
        .then((response) => {
          this.quiz = response.data;
        })
        .catch((error) => {
          if (axios.isCancel(error)) {
            console.log("Request canceled", error.message);
          } else {
            this.error = "クイズの取得に失敗しました。再度お試しください。";
            console.error(error);
          }
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    formatText(text) {
      return text.replace(/\s/g, "<br>");
    },
  },
};
</script>
