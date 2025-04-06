import Vue from 'vue'
import VueRouter from 'vue-router'
import auth from "@/middlewares/auth";
import redirectToMain from "@/middlewares/redirectToMain";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'dashboard',
    meta: { middleware: auth },
    component: () => import('./../pages/Dashboard.vue')
  },
  {
    path: '/login',
    name: 'login',
    meta: {
      middleware: redirectToMain,
      without_auth: true
    },
    component: () => import('./../pages/login/LoginPage.vue')
  },
  {
    path: '/roles',
    name: 'roles',
    meta: { middleware: auth },
    component: () => import('../pages/roles/IndexPage.vue')
  },
  {
    path: '/roles/:id/edit',
    name: 'roles-edit',
    meta: { middleware: auth },
    component: () => import('../pages/roles/EditPage.vue')
  },
  {
    path: '/roles/store',
    name: 'roles-store',
    meta: { middleware: auth },
    component: () => import('../pages/roles/CreatePage.vue')
  },
  {
    path: '/users',
    name: 'users',
    meta: { middleware: auth },
    component: () => import('../pages/users/IndexPage.vue')
  },
  {
    path: '/users/:id/edit',
    name: 'users-edit',
    meta: { middleware: auth },
    component: () => import('../pages/users/EditPage.vue')
  },
  {
    path: '/users/store',
    name: 'users-store',
    meta: { middleware: auth },
    component: () => import('../pages/users/CreatePage.vue')
  },
  {
    path: '/couriers',
    name: 'couriers',
    meta: { middleware: auth },
    component: () => import('../pages/couriers/IndexPage.vue')
  },
  {
    path: '/inactive-couriers',
    name: 'inactive-couriers',
    meta: { middleware: auth },
    component: () => import('../pages/inactive_couriers/IndexPage.vue')
  },
  {
    path: '/couriers/:id',
    name: 'couriers-show',
    meta: { middleware: auth },
    component: () => import('../pages/couriers/ShowPage.vue')
  },
  {
    path: '/couriers/store',
    name: 'couriers-store',
    meta: { middleware: auth },
    component: () => import('../pages/couriers/CreatePage.vue')
  },
  {
    path: '/courier-registrations',
    name: 'registrations',
    meta: { middleware: auth },
    component: () => import('../pages/registration/IndexPage.vue')
  },
  {
    path: '/courier-registrations/:id',
    name: 'registrations-edit',
    meta: { middleware: auth },
    component: () => import('../pages/registration/EditPage.vue')
  },
  {
    path: '/cabinets',
    name: 'cabinets',
    meta: { middleware: auth },
    component: () => import('../pages/cabinets/IndexPage.vue')
  },
  {
    path: '/cabinets/:id',
    name: 'cabinets-show',
    meta: { middleware: auth },
    component: () => import('../pages/cabinets/ShowPage.vue')
  },
  {
    path: '/reports/summary',
    name: 'summary',
    meta: { middleware: auth },
    component: () => import('../pages/reports/summary/IndexPage.vue')
  },

]

const index = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

index.beforeEach((to, from, next) => {
  if (to.meta.middleware) {
    to.meta.middleware(next, index);
  } else {
    next();
  }
});

export default index
