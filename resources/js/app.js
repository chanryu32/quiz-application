require('./bootstrap');

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import IndexComponent from './components/quiz/Index.vue';

window.createApp = createApp;
window.IndexComponent = IndexComponent;
