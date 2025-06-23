import { createRouter, createWebHistory } from 'vue-router'
import App from '../App.vue';

const BASE_URL = import.meta.env.VITE_APP_BACKEND_URL;

const router = createRouter({
  history: createWebHistory(BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: App,
      meta: { requiresAuth: false }
    },
  ]
})

export default router;
