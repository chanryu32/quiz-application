<template>
  <div>
    <h1>Home</h1>
    <router-link to="./quiz" class="btn btn-outline-primary btn-sm"
      >Quizプレイ画面</router-link
    >
    <router-link to="./quiz-management" class="btn btn-outline-secondary btn-sm"
      >Quiz管理画面</router-link
    >
  </div>
</template>

<script>
export default {
  name: "Home",
};
</script>
