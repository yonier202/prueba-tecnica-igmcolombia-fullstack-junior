export default [
  {
    path: '/personas',
    name: 'personas',
    component: () => import('./views/PersonaView.vue'),
    meta: { requiresAuth: true }
  }
]
