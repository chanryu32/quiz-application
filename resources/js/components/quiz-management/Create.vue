<template>
  <div>
    <h1>Quiz 管理 - 問題の追加</h1>
    <div v-if="Object.keys(validationErrors).length">
      <div class="alert alert-danger">
        <ul>
          <li v-for="error in validationErrors">{{ error[0] }}</li>
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
          >一覧に戻る</router-link
        >
      </div>
    </form>
  </div>
  <div v-if="isLoading" class="spinner"></div>
</template>

<script setup>
import axios from "axios";
import { ref, onBeforeUnmount, onMounted } from "vue";
import { useRouter } from "vue-router";

const question = ref("");
const answers = [
  { label: "A", value: "", placeholder: "Aの答えを入力..." },
  { label: "B", value: "", placeholder: "Bの答えを入力..." },
  { label: "C", value: "", placeholder: "Cの答えを入力..." },
  { label: "D", value: "", placeholder: "Dの答えを入力..." },
];
const correctAnswer = ref("");
const explanation = ref("");
const validationErrors = ref([]);
const isLoading = ref(false);
const cancelRequest = ref(null);
const router = useRouter();

onBeforeUnmount(() => {
  if (cancelRequest.value) {
    cancelRequest.value();
  }
});

const submitForm = async () => {
  isLoading.value = true;

  const formData = new FormData();

  formData.append("question", question.value);
  formData.append("answer_a", answers[0].value);
  formData.append("answer_b", answers[1].value);
  formData.append("answer_c", answers[2].value);
  formData.append("answer_d", answers[3].value);
  formData.append("correct_answer", correctAnswer.value);
  formData.append("explanation", explanation.value);

  try {
    await axios.post("/quizManagementAPI", formData, {
      cancelToken: new axios.CancelToken((c) => {
        cancelRequest.value = c;
      }),
    });

    router.push("/quiz-management");
  } catch (error) {
    if (axios.isCancel(error)) {
      console.log("Request canceled", error.message);
    } else if (error.response.status == 422) {
      scrollToTop();
      validationErrors.value = error.response.data.errors;
    } else {
      error.value = "クイズの登録に失敗しました。再度お試しください。";
      console.error(error);
    }
  } finally {
    isLoading.value = false;
  }
};
const scrollToTop = () => {
  document.documentElement.scrollTop = 0;
};
</script>
