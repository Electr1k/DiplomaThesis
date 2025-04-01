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
      component: () => import('../pages/roles/IndexPage.vue')
    },
    {
      path: '/clients',
      name: 'clients',
      component: () => import('../pages/roles/IndexPage.vue')
    },
    {
      path: '/reports',
      name: 'reports',
      component: () => import('../pages/roles/IndexPage.vue')
    },

  ]

  const index = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
  })

  export default index
