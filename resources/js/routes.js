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
    name: 'home',
    component: Home,
  },
  {
    path: '/quiz',
    name: 'quizIndex',
    component: QuizIndex,
  },
  {
    path: '/quiz/show/:id',
    name: 'quizShow',
    component: QuizShow,
    props: true,
  },
  {
    path: '/quiz-management',
    name: 'quiz-manegementIndex',
    component: QuizManagementIndex,
  },
  {
    path: '/quiz-management/show/:id',
    name: 'quizManegementShow',
    component: QuizManagementShow,
    props: true,
  },
  {
    path: '/quiz-management/create',
    name: 'quizManegementCreate',
    component: QuizManagementCreate,
  }, {
    path: '/quiz-management/edit/:id',
    name: 'quizManegementEdit',
    component: QuizManagementEdit,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
