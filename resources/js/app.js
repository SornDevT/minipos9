import './bootstrap'

import { createApp } from 'vue'
import router from './router'
import App from './App.vue'
import Menu from './components/Menu.vue'
import Pagination from './components/Pagination.vue'
import './service/axios'

import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

import Cleave from 'vue-cleave-component'

import { createPinia } from 'pinia'
const pinia = createPinia()

import GrapBoard from './components/GrapBoard.vue'


const app = createApp(App)
app.use(VueSweetalert2)
app.use(Cleave)
app.use(router)
app.use(pinia)
app.component("GrapBoard",GrapBoard)
app.component("SildeBarMenu",Menu)
app.component("pagination",Pagination)
app.mount("#app-vue")