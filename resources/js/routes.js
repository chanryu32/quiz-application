import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home';
import QuizIndex from './components/quiz/Index';
import QuizShow from './components/quiz/Show';
import QuizManagementIndex from './components/quiz-management/Index';
import QuizManagementShow from './components/quiz-management/Show';
import QuizManagementCreate from './components/quiz-management/Create';
import QuizManagementEdit from './components/quiz-management/Edit';

const routes = [
  {
    path: '/home',
    component: Home,
  },
  {
    path: '/quiz',
    component: QuizIndex,
  },
  {
    path: '/quiz/show/:id',
    component: QuizShow,
    props: true,
  },
  {
    path: '/quiz-management',
    component: QuizManagementIndex,
  },
  {
    path: '/quiz-management/show/:id',
    component: QuizManagementShow,
    props: true,
  },
  {
    path: '/quiz-management/create',
    component: QuizManagementCreate,
  }, {
    path: '/quiz-management/edit/:id',
    component: QuizManagementEdit,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
