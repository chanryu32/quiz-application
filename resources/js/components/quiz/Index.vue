<template>
  <div class="col mt-3 mb-5">
    <h1>Quiz!</h1>
  </div>
  <div class="row mt-5 mb-3">
    <div class="col text-right">
      <router-link to="/quiz-management" class="btn btn-primary">
        クイズ管理画面
      </router-link>
    </div>
  </div>
  <div class="row my-3">
    <table class="table table-hover table-sm" id="quizzes-table">
      <thead class="thead-light">
        <tr>
          <th scope="col">問題</th>
          <th scope="col" style="width: 1.5%"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quiz in quizzes" :key="quiz.id">
          <td>
            <router-link :to="'/quiz/show/' + quiz.id">
              {{
                quiz.question.substr(0, 60) +
                (quiz.question.length > 60 ? "..." : "")
              }}</router-link
            >
          </td>
          <td scope="row" v-if="isCreatedInWeek(quiz.updated_at)">New!</td>
          <td scope="row" v-else></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div v-if="isLoading" class="spinner"></div>
  <div v-if="error" class="error-container">{{ error }}</div>
</template>

<script>
export default {
  data() {
    return {
      quizzes: [],
      isLoading: false,
      error: null,
    };
  },
  created() {
    this.fetchQuizzes();
  },
  beforeUnmount() {
    this.cancelRequest();
  },
  methods: {
    async fetchQuizzes() {
      this.isLoading = true;
      try {
        const response = await axios.get("/quizIndexAPI", {
          cancelToken: new axios.CancelToken((c) => {
            this.cancelRequest = c;
          }),
        });
        this.quizzes = response.data;
      } catch (error) {
        if (axios.isCancel(error)) {
          console.log("Request canceled", error.message);
        } else {
          this.error = "クイズの取得に失敗しました。再度お試しください。";
          console.error(error);
        }
      } finally {
        this.isLoading = false;
      }
    },
    isCreatedInWeek(date) {
      const today = new Date();
      const createdAt = new Date(date);
      const diffTime = Math.abs(createdAt - today);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      return diffDays <= 7;
    },
  },
};
</script>
