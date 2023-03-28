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
    <table class="table table-striped table-hover table-sm" id="quizzes-table">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 10%">ID</th>
          <th scope="col">問題</th>
          <th scope="col" style="width: 11%">操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(quiz, index) in quizzes" :key="quiz.id">
          <th scope="row">{{ quiz.id }}</th>
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
</template>

<script>
export default {
  data() {
    return {
      quizzes: [],
    };
  },
  methods: {
    deleteQuiz(id, index) {
      // 削除前の確認を表示
      if (!confirm("id:" + id + " のQuizを削除します\nよろしいですか?")) {
        return;
      }

      axios
        .delete("/quizManagementAPI/" + id)
        .then((response) => {
          // リクエストが正常に処理された場合

          // quizzes配列から削除
          this.quizzes.splice(index, 1);
          // メッセージ表示
          alert("削除しました");
          console.log(response);
        })
        .catch((error) => {
          // リクエストで何らかのエラーが発生した場合
          alert(error);
          console.log(error);
        });
    },
    fetchQuiz() {
      axios
        .get("/quizIndexAPI")
        .then((response) => {
          this.quizzes = response.data;
          console.log(response);
        })
        .catch((error) => {
          // リクエストで何らかのエラーが発生した場合
          alert(error);
          console.log(error);
        });
    },
  },
  created() {
    this.fetchQuiz();
  },
};
</script>
