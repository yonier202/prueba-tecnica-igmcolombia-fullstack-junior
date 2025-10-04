export default [
  {
    path: '/roles',
    name: 'roles',
    component: () => import('./views/rolesView.vue'),
    meta: { requiresAuth: true }
  }
]
