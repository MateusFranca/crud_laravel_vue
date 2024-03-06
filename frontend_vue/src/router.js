import { createRouter, createWebHistory } from 'vue-router';
import ClientesList from './pages/Client/ClientesList.vue';
import ClienteAdicionar from './pages/Client/ClienteAdicionar.vue';
import LoginComponent  from './pages/Log/LoginComponent.vue';
import RegistroComponent from './pages/Log/RegistroComponent.vue';

const routes = [
  { path: '/', redirect: '/login', },
  { path: '/clientes', name: 'Clientes', component: ClientesList, meta: { requiresAuth: true } },
  { path: '/clientes/adicionar', name: 'ClienteAdicionar', component: ClienteAdicionar, meta: { requiresAuth: true } },
  { path: '/login', name: 'Login', component: LoginComponent },
  { path: '/registro', name: 'Registro', component: RegistroComponent },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, _from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!localStorage.getItem('token')) {
      next({ name: 'Login' });
    } else {
      next();
    }
  } else {
    next();
  }
}); 

export default router;