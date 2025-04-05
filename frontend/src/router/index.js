  import Vue from 'vue'
  import VueRouter from 'vue-router'

  Vue.use(VueRouter)

  const routes = [
    {
      path: '/',
      name: 'dashboard',
      component: () => import('./../pages/Dashboard.vue')
    },
    {
      path: '/roles',
      name: 'roles',
      component: () => import('../pages/roles/IndexPage.vue')
    },
    {
      path: '/roles/:id/edit',
      name: 'roles-edit',
      component: () => import('../pages/roles/EditPage.vue')
    },
    {
      path: '/roles/store',
      name: 'roles-store',
      component: () => import('../pages/roles/CreatePage.vue')
    },
    {
      path: '/users',
      name: 'users',
      component: () => import('../pages/users/IndexPage.vue')
    },
    {
      path: '/users/:id/edit',
      name: 'users-edit',
      component: () => import('../pages/users/EditPage.vue')
    },
    {
      path: '/users/store',
      name: 'users-store',
      component: () => import('../pages/users/CreatePage.vue')
    },
    {
      path: '/couriers',
      name: 'couriers',
      component: () => import('../pages/couriers/IndexPage.vue')
    },
    {
      path: '/couriers/:id',
      name: 'couriers-show',
      component: () => import('../pages/couriers/ShowPage.vue')
    },
    {
      path: '/couriers/store',
      name: 'couriers-store',
      component: () => import('../pages/couriers/CreatePage.vue')
    },
    {
      path: '/courier-registrations',
      name: 'registrations',
      component: () => import('../pages/registration/IndexPage.vue')
    },
    {
      path: '/courier-registrations/:id',
      name: 'registrations-edit',
      component: () => import('../pages/registration/EditPage.vue')
    },
    {
      path: '/cabinets',
      name: 'cabinets',
      component: () => import('../pages/cabinets/IndexPage.vue')
    },
    {
      path: '/cabinets/:id',
      name: 'cabinets-show',
      component: () => import('../pages/cabinets/ShowPage.vue')
    },
    {
      path: '/reports/summary',
      name: 'summary',
      component: () => import('../pages/reports/summary/IndexPage.vue')
    },

  ]

  const index = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
  })

  export default index
