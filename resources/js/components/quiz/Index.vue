<template>
  <div class="col mt-3 mb-5">
    <h1>Quiz!</h1>
  </div>
  <div class="row mt-5 mb-3">
    <div class="col text-right">
      <a href="/quiz-maintenance" type="button" class="btn btn-primary"
        >クイズ管理画面</a
      >
    </div>
  </div>
  <div class="row my-3">
    <table class="table table-striped table-hover table-sm" id="quizzes-table">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 10%">ID</th>
          <th scope="col">問題</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quiz in quizzes" :key="quiz.id">
          <th scope="row">{{ quiz.id }}</th>
          <td>
            <a :href="'/quiz/' + quiz.id">
              {{
                quiz.question.substr(0, 60) +
                (quiz.question.length > 60 ? "..." : "")
              }}
            </a>
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
  created() {
    axios
      .get("/quiz/indexAPI")
      .then((response) => {
        this.quizzes = response.data.concat();

        console.log(response);
      })
      .catch((error) => {
        // リクエストで何らかのエラーが発生した場合
        alert(error);
        console.log(error);
      });
  },
  mounted() {},
};
</script>

<style scoped>
#greeting_box {
  background-color: #ffeeee;
}
</style>
