<template>
  <div>
    <h1>Quiz 管理 - 問題の追加</h1>
    <div v-if="Object.keys(errors).length">
      <div class="alert alert-danger">
        <ul>
          <li v-for="error in errors" :key="error">{{ error[0] }}</li>
        </ul>
      </div>
    </div>
    <form @submit.prevent="submitForm">
      <div class="mt-3 mb-5">
        <h2>問題</h2>
        <div class="form-group">
          <label for="questionTextarea">問題文</label>
          <textarea
            v-model="question"
            class="form-control"
            id="questionTextarea"
            rows="3"
          ></textarea>
        </div>
        <div class="mt-1">
          <span>選択肢</span>
          <div
            v-for="(answer, index) in answers"
            :key="index"
            class="input-group flex-nowrap my-2"
          >
            <div class="input-group-prepend">
              <span class="input-group-text" :id="'answer-' + index">{{
                answer.label
              }}</span>
            </div>
            <input
              v-model="answer.value"
              type="text"
              class="form-control"
              :placeholder="answer.placeholder"
              :aria-label="'回答' + answer.label"
              :aria-describedby="'answer-' + index"
            />
          </div>
        </div>
      </div>
      <div class="mt-3 mb-5">
        <h2>正しい答え</h2>
        <div class="form-group">
          <label for="correctAnswerSelect">正しい選択肢</label>
          <select
            v-model="correctAnswer"
            class="form-control"
            id="correctAnswerSelect"
          >
            <option value="" disabled>正しい回答を選択...</option>
            <option
              v-for="answer in answers"
              :key="answer.label"
              :value="answer.label"
              v-text="answer.label"
              :selected="answer.label === correctAnswer"
            ></option>
          </select>
        </div>
        <div class="form-group">
          <label for="explanationTextarea">解説</label>
          <textarea
            v-model="explanation"
            class="form-control"
            id="explanationTextarea"
            rows="3"
          ></textarea>
        </div>
      </div>
      <div class="mt-3 mb-5">
        <button type="submit" class="btn btn-primary">追加</button>
        <router-link to="/quiz-management" class="btn btn-link"
          >戻る</router-link
        >
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      question: "",
      answers: [
        { label: "A", value: "", placeholder: "Aの答えを入力" },
        { label: "B", value: "", placeholder: "Bの答えを入力" },
        { label: "C", value: "", placeholder: "Cの答えを入力" },
        { label: "D", value: "", placeholder: "Dの答えを入力" },
      ],
      correctAnswer: "",
      explanation: "",
      errors: [],
    };
  },
  methods: {
    submitForm() {
      const formData = new FormData();

      formData.append("question", this.question);
      formData.append("answer_a", this.answers[0].value);
      formData.append("answer_b", this.answers[1].value);
      formData.append("answer_c", this.answers[2].value);
      formData.append("answer_d", this.answers[3].value);
      formData.append("correct_answer", this.correctAnswer);
      formData.append("explanation", this.explanation);

      // axiosでフォームデータを送信
      axios
        .post("/quizManagementAPI", formData)
        .then((response) => {
          this.$router.push("/quiz-management");
        })
        .catch((error) => {
          // リクエストで何らかのエラーが発生した場合
          this.errors = error.response.data.errors;
          this.scrollToTop();
          console.log(error.message);
        });
    },
    scrollToTop() {
      document.documentElement.scrollTop = 0;
    },
  },
};
</script>