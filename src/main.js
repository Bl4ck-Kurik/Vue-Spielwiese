import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { plugin, defaultConfig } from '@formkit/vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

import Ninja from "@/views/NinjaView.vue"
import Modal from "@/views/ModalView.vue"
import Signup from "@/views/SignupView.vue"
import Todo from "@/views/TodoView.vue"
import Note from "@/views/NoteView.vue"
import File from "@/views/FileView.vue"
import FormKit from "@/views/FormKitView.vue"

import '@/assets/global.css'
import '@formkit/themes/genesis'

const routes = [
  { path: '/ninja', component: Ninja },
  { path: '/modal', component: Modal },
  { path: '/signup', component: Signup },
  { path: '/todo', component: Todo },
  { path: '/notes', component: Note },
  { path: '/files', component: File },
  { path: '/form-kit', component: FormKit },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

const app = createApp(App)
app.use(VueAxios, axios)  
app.use(router)
app.use(plugin, defaultConfig)
app.mount('#app')