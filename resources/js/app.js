require('./bootstrap');

import { createApp } from 'vue';
import IndexComponent from './components/quiz/Index';
import router from './routes';

createApp({
  components: {
    'v-index': IndexComponent
  }
}).use(router)
  .mount('#app');