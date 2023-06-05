import './bootstrap';

import { createApp } from 'vue';
import router from './router';
import App from './App.vue';
import Menu from './components/Menu.vue';
import Pagination from './components/Pagination.vue'
import './service/axios';

import { createPinia } from 'pinia';
const pinia = createPinia();


const app = createApp(App)
app.use(router)
app.use(pinia)
app.component("SildeBarMenu",Menu)
app.component("pagination",Pagination)
app.mount("#app-vue")