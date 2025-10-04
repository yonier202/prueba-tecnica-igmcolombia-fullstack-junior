import { createRouter, createWebHistory } from 'vue-router'

import authRoutes from '../modules/auth/router'
import facturacionRoutes from '../modules/facturacion/router'
import rolesRoutes from '../modules/roles/router'
import personasRoutes from '../modules/personas/router'


const routes = [
  ...authRoutes,
  ...facturacionRoutes,
  ...rolesRoutes,
  ...personasRoutes
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  // Recuperar usuario del localStorage
  const userData = localStorage.getItem('user')
  let token = null

  try {
    const user = JSON.parse(userData)
    token = user?.token || null
  } catch (e) {
    token = null
  }

  if (to.meta.requiresAuth && !token) {
    next({ name: 'login' })
  }
  else if (to.name === 'login' && token) {
    next({ name: 'facturacion' })
  }
  else {
    next()
  }
})


export default router
