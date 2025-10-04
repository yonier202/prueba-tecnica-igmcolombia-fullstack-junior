export default [
  {
    path: '/facturacion',
    name: 'facturacion',
    component: () => import('./views/FacturacionView.vue'),
    meta: { requiresAuth: true }
  }
]
