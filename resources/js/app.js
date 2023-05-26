import './bootstrap';

import { createApp } from 'vue';
import router from './router';
import App from './App.vue';
import Menu from './components/Menu.vue';


const app = createApp(App)
app.use(router)
app.component("SildeBarMenu",Menu)
app.mount("#app-vue")