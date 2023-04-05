<template>
  <div class="col mt-3 mb-5">
    <h1>Quiz 管理</h1>
  </div>
  <div class="row mt-5 mb-3">
    <div class="col text-right">
      <router-link to="/quiz" class="btn btn-primary" style="margin-right: 10px"
        >クイズをプレイ！</router-link
      >
      <router-link to="/quiz-management/create" class="btn btn-primary"
        >追加</router-link
      >
    </div>
  </div>
  <div class="row my-3">
    <table class="table table-hover table-sm" id="quizzes-table">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 5%">ID</th>
          <th scope="col" style="width: 1.5%"></th>
          <th scope="col">問題</th>
          <th scope="col" style="width: 11%">操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(quiz, index) in quizzes" :key="quiz.id">
          <th scope="row">{{ quiz.id }}</th>
          <td scope="row" v-if="isCreatedInWeek(quiz.updated_at)">New!</td>
          <td scope="row" v-else></td>
          <td>
            <router-link :to="'/quiz-management/show/' + quiz.id">
              {{
                quiz.question.substr(0, 60) +
                (quiz.question.length > 60 ? "..." : "")
              }}
            </router-link>
          </td>
          <td>
            <div style="display: flex; justify-content: space-between">
              <router-link
                :to="'/quiz-management/edit/' + quiz.id"
                class="btn btn-outline-primary btn-sm"
                >編集</router-link
              >
              <button
                @click="deleteQuiz(quiz.id, index)"
                class="delete-quiz btn btn-outline-danger btn-sm"
              >
                削除
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div v-if="isLoading" class="spinner"></div>
  <div v-if="error" class="error-container">{{ error }}</div>
  <div v-if="message" class="message-container">{{ message }}</div>
</template>

<script>
export default {
  data() {
    return {
      quizzes: [],
      error: null,
      messege: null,
      isLoading: false,
    };
  },
  created() {
    this.fetchQuizzes();
  },
  beforeUnmount() {
    this.cancelRequest();
  },
  methods: {
    async deleteQuiz(id, index) {
      // 削除前の確認を表示
      if (!confirm("id:" + id + " のQuizを削除します\nよろしいですか?")) {
        return;
      }

      this.isLoading = true;
      try {
        const response = await axios.delete(`/quizManagementAPI/${id}`, {
          cancelToken: new axios.CancelToken((c) => {
            this.cancelRequest = c;
          }),
        });

        // quizzes配列から削除
        this.quizzes.splice(index, 1);
        // メッセージ表示
        this.message = "削除しました";
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
    scrollToTop() {
      document.documentElement.scrollTop = 0;
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
