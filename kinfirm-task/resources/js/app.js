import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import ProductList from './components/ProductList.vue';
import ProductDetail from './components/ProductDetail.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import store from './store'; // Import the store
import NotFound from './components/NotFound.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/', component: ProductList, meta: { requiresAuth: true } },
  { path: '/product/:id', component: ProductDetail, meta: { requiresAuth: true } },
  { path: '/:catchAll(.*)', component: NotFound }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach(async (to, from, next) => {
  const isAuthenticated = store.getters.isAuthenticated; // Get authentication status from Vuex store

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      // If not authenticated, redirect to login
      next('/login');
    } else {
      // If authenticated, proceed to the route
      next();
    }
  } else {
    // If route doesn't require authentication, proceed to the route
    next();
  }
});

const app = createApp(App);
app.use(store); // Use the store
app.use(router);
app.mount('#app');
