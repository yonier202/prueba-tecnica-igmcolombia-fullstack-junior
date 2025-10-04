import { defineStore } from 'pinia'
import { ref } from 'vue'
import FacturacionService from '../services/FacturacionService'
import { useAuthStore } from '../../auth/stores/auth'
import Swal from 'sweetalert2';

export const useFacturacionStore = defineStore('facturacion', () => {
  const auth = useAuthStore()

  const facturas = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function navPermisos() {
    try {
      const { data: { role_id } } = await FacturacionService.permisosNav(auth.user.data.id)
      auth.user.permisos = role_id == 1 ? 'admin' : 'user'
    } catch (err) {
      console.error('Error al obtener permisos:', err)
      error.value = err
      throw err
    }
  }


  async function fetchFacturas() {
    loading.value = true
    error.value = null
    try {
      const { data } = await FacturacionService.getAll()
      facturas.value = data.data ?? data
    } catch (err) {
      console.error('Error al obtener facturas:', err)
      error.value = err
    } finally {
      loading.value = false
    }
  }

  async function Alerta(type, msj, icon){
    Swal.fire({
        title: type,
            text:  msj,
            icon: icon,
            confirmButtonText: 'Aceptar'
        });
    }


  async function crearFactura(payload) {
    try {
      loading.value = true
      error.value = null
      const formData = payload instanceof FormData ? payload : new FormData()


      if (!(payload instanceof FormData)) {
        for (const key in payload) {
          if (key === 'items') {
            payload[key].forEach((item, i) => {
              formData.append(`items[${i}][nombre]`, item.nombre)
              formData.append(`items[${i}][cantidad]`, item.cantidad)
              formData.append(`items[${i}][iva]`, item.iva)
              formData.append(`items[${i}][precio_unitario]`, item.precio_unitario)
            })
            Alerta('Exito', 'Factura Creada con exito', 'success');
          } else {
            formData.append(key, payload[key])
          }
        }
      }

      await FacturacionService.create(formData)
      await fetchFacturas()
    } catch (err) {
      console.error('Error al crear factura:', err)
      error.value = err
      throw err
    } finally {
      loading.value = false
    }
  }

  async function actualizarFactura(id, payload) {
    try {
        payload.append("_method", "PUT");
        loading.value = true
        await FacturacionService.update(id, payload)
        await Alerta('Exito', 'Factura Actualizada con exito', 'success');
        await fetchFacturas()
    } catch (err) {
        console.error('Error al actualizar factura:', err)
        error.value = err
        throw err
    } finally {
        loading.value = false
    }
  }


  async function eliminarFactura(id) {
    try {
      await FacturacionService.delete(id)
      facturas.value = facturas.value.filter(f => f.id !== id)
      Alerta('Exito', 'Factura Eliminada con exito', 'success');
    } catch (err) {
      console.error('Error al eliminar factura:', err)
      error.value = err
      throw err
    }
  }

  return {
    facturas,
    loading,
    error,
    navPermisos,
    fetchFacturas,
    crearFactura,
    actualizarFactura,
    eliminarFactura,
  }
})
