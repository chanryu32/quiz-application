require('./bootstrap');

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import HelloComponent from './components/Hello.vue';

window.createApp = createApp;
window.HelloComponent = HelloComponent;
