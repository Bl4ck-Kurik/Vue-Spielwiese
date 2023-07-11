import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from '@/App.vue'

import Ninja from "@/views/NinjaView.vue"
import Modal from "@/views/ModalView.vue"
import Signup from "@/views/SignupView.vue"
import Todo from "@/views/TodoView.vue"
import Note from "@/views/NoteView.vue"
import File from "@/views/FileView.vue"

import '@/assets/global.css'

const routes = [
  { path: '/ninja', component: Ninja },
  { path: '/modal', component: Modal },
  { path: '/signup', component: Signup },
  { path: '/todo', component: Todo },
  { path: '/notes', component: Note },
  { path: '/files', component: File },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

const app = createApp(App)
app.use(router)
app.mount('#app')