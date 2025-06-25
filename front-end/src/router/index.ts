import { createRouter, createWebHistory } from 'vue-router'
import TLD from '../components/TLD.vue';
import HomeView from '../views/HomeView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/components/tld',
      name: 'tld',
      component: TLD
    },
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
  ]
})

export default router;
