require('./bootstrap');

import { createApp } from 'vue';
import router from './routes';

const app = createApp({
}).use(router)
  .mount('#app');