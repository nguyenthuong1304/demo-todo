import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Layout from '@/layout'

export const constantRoutes = [
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    hidden: true
  },

  {
    path: '/404',
    component: () => import('@/views/404'),
    hidden: true
  },

  {
    path: '/',
    component: Layout,
    redirect: '/dashboard',
    children: [{
      path: 'dashboard',
      name: 'Dashboard',
      component: () => import('@/views/dashboard/index'),
      meta: { title: 'Dashboard', icon: 'dashboard' }
    }]
  },

  {
    path: '/todos',
    component: Layout,
    redirect: '/',
    name: 'Xử lý chính',
    children: [
      {
        path: '',
        name: 'todo_index',
        component: () => import('@/views/todos/index'),
        meta: { title: 'Danh mục', icon: 'form' }
      },
      {
        path: 'edit/:id(\\d+)',
        name: 'todo_edit',
        component: () => import('@/views/todos/edit'),
        meta: { title: 'Cập nhật danh mục' },
        hidden: true
      },
      {
        path: 'create',
        name: 'todo_create',
        component: () => import('@/views/todos/create'),
        meta: { title: 'Tạo mới danh mục' },
        hidden: true
      }
    ]
  },

  { path: '*', redirect: '/404', hidden: true }
]

const createRouter = () => new Router({
  mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

const router = createRouter()

export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router
