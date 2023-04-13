<template>
  <div class="col mt-3 mb-5">
    <h1>Quiz 管理</h1>
  </div>
  <div class="row mt-5 mb-3">
    <div class="col text-right">
      <router-link
        to="/quiz"
        id="btnQuiz"
        class="btn btn-primary"
        style="margin-right: 10px"
        >クイズをプレイ！</router-link
      >
      <router-link
        to="/quiz-management/create"
        id="btnAdd"
        class="btn btn-primary"
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
                quiz.question.substring(0, 60) +
                (quiz.question.length > 60 ? "..." : "")
              }}
            </router-link>
          </td>
          <td>
            <div style="display: flex; justify-content: space-between">
              <router-link
                :to="'/quiz-management/edit/' + quiz.id"
                class="btn btn-outline-primary btn-sm"
                id="btnEdit"
                >編集</router-link
              >
              <button
                @click="deleteQuiz(quiz.id, index)"
                class="delete-quiz btn btn-outline-danger btn-sm"
                id="btnDelete"
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

<script setup lang="ts">
import axios, { Canceler } from "axios";
import { ref, onBeforeUnmount, onMounted } from "vue";
import { Quiz } from "../../types/Quiz";

const quizzes = ref<Quiz[]>([]);
const isLoading = ref<boolean>(false);
const error = ref<any>(null);
const message = ref<any>(null);
const cancelRequest = ref<Canceler | null>(null);

const fetchQuizzes = async (): Promise<void> => {
  isLoading.value = true;
  try {
    const { data } = await axios.get<Quiz[]>("/quizIndexAPI", {
      cancelToken: new axios.CancelToken((canceler: Canceler) => {
        cancelRequest.value = canceler;
      }),
    });
    quizzes.value = data;
  } catch (error: any) {
    if (axios.isCancel(error)) {
      console.log("Request canceled", error.message);
    } else {
      error.value = "クイズの取得に失敗しました。再度お試しください。";
      console.error(error);
    }
  } finally {
    isLoading.value = false;
  }
};

const isCreatedInWeek = (date: string): boolean => {
  const today: Date = new Date();
  const createdAt: Date = new Date(date);
  const diffTime: number = Math.abs(createdAt.getTime() - today.getTime());
  const diffDays: number = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
  return diffDays <= 7;
};

const deleteQuiz = async (id: string, index: number): Promise<void> => {
  // 削除前の確認を表示
  if (!confirm("id:" + id + " のQuizを削除します\nよろしいですか?")) {
    return;
  }

  isLoading.value = true;
  try {
    await axios.delete(`/quizManagementAPI/${id}`, {
      cancelToken: new axios.CancelToken((canceler: Canceler) => {
        cancelRequest.value = canceler;
      }),
    });

    // quizzes配列から削除
    quizzes.value.splice(index, 1);
    scrollToTop();
    message.value = "削除しました";
  } catch (error: any) {
    if (axios.isCancel(error)) {
      console.log("Request canceled", error.message);
    } else {
      error.value = "クイズの取得に失敗しました。再度お試しください。";
      console.error(error);
    }
  } finally {
    isLoading.value = false;
  }
};

const scrollToTop = (): void => {
  document.documentElement.scrollTop = 0;
};

onMounted(async () => {
  await fetchQuizzes();
});

onBeforeUnmount(() => {
  if (cancelRequest.value) {
    cancelRequest.value();
  }
});
</script>
