<script setup>
import { ref, computed, onMounted } from "vue";
import { useFacturacionStore } from "../stores/facturacion";
import FacturaForm from "./FacturaForm.vue";

const facturaStore = useFacturacionStore();

const buscar = ref("");
const pagina = ref(1);
const porPagina = 5;
const mostrarFormulario = ref(false);
const facturaSeleccionada = ref(null);

onMounted(() => {
  facturaStore.fetchFacturas();
});

const facturasFiltradas = computed(() => {
  const query = buscar.value.toLowerCase();
  return facturaStore.facturas.filter(
    (f) =>
      f.numero_factura.toLowerCase().includes(query) ||
      f.descripcion.toLowerCase().includes(query) ||
      (f.persona?.nombres?.toLowerCase() || "").includes(query)
  );
});

const totalPaginas = computed(() =>
  Math.ceil(facturasFiltradas.value.length / porPagina)
);

const facturasPaginadas = computed(() => {
  const start = (pagina.value - 1) * porPagina;
  return facturasFiltradas.value.slice(start, start + porPagina);
});

const cambiarPagina = (nueva) => {
  if (nueva >= 1 && nueva <= totalPaginas.value) pagina.value = nueva;
};

const eliminarFactura = async (id) => {
  if (confirm("¿Seguro que deseas eliminar esta factura?")) {
    await facturaStore.eliminarFactura(id);
  }
};

const abrirFormulario = (factura = null) => {
  facturaSeleccionada.value = factura;
  mostrarFormulario.value = true;
};

const cerrarFormulario = () => {
  mostrarFormulario.value = false;
  facturaSeleccionada.value = null;
};
</script>

<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <div class="bg-white shadow-xl rounded-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800"> Facturas</h2>
      </div>

      <div class="mb-4">
        <input
          v-model="buscar"
          type="text"
          placeholder="Buscar por número, descripción o cliente..."
          class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-indigo-400"
        />
      </div>

      <div v-if="facturaStore.loading" class="text-center py-6 text-gray-500">
        Cargando facturas...
      </div>

      <div v-else-if="facturasPaginadas.length > 0" class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg">
          <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
            <tr>
              <th class="p-3">#</th>
              <th class="p-3">Cliente</th>
              <th class="p-3">N° Factura</th>
              <th class="p-3">Descripción</th>
              <th class="p-3">Monto Total</th>
              <th class="p-3">Estado</th>
              <th class="p-3 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(factura, i) in facturasPaginadas"
              :key="factura.id"
              class="border-t hover:bg-gray-50 transition"
            >
              <td class="p-3">{{ (pagina - 1) * porPagina + i + 1 }}</td>
              <td class="p-3">
                {{ factura.persona?.nombres }} {{ factura.persona?.apellidos }}
              </td>
              <td class="p-3 font-medium text-gray-800">
                {{ factura.numero_factura }}
              </td>
              <td class="p-3 text-gray-600 truncate">{{ factura.descripcion }}</td>
              <td class="p-3 font-semibold text-green-600">
                ${{ factura.monto_total }}
              </td>
              <td class="p-3">
                <span
                  :class="{
                    'bg-yellow-100 text-yellow-800 px-2 py-1 rounded': factura.estado === 'pendiente',
                    'bg-green-100 text-green-800 px-2 py-1 rounded': factura.estado === 'pagada',
                    'bg-red-100 text-red-800 px-2 py-1 rounded': factura.estado === 'vencida',
                  }"
                >
                  {{ factura.estado }}
                </span>
              </td>
              <td class="p-3 flex gap-2 justify-center">
                <button
                  @click="abrirFormulario(factura)"
                  class="bg-indigo-100 hover:bg-indigo-200 text-indigo-600 px-2 py-1 rounded-md"
                >
                  Editar
                </button>
                <button
                  @click="eliminarFactura(factura.id)"
                  class="bg-red-100 hover:bg-red-200 text-red-600 px-2 py-1 rounded-md"
                >
                  Eliminar
                </button>

              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-else class="text-center py-6 text-gray-500">
        No se encontraron facturas.
      </div>

      <div
        v-if="totalPaginas > 1"
        class="flex justify-center items-center mt-4 gap-2"
      >
        <button
          @click="cambiarPagina(pagina - 1)"
          :disabled="pagina === 1"
          class="px-3 py-1 rounded-md border bg-gray-100 hover:bg-gray-200 disabled:opacity-50"
        >
          ◀
        </button>
        <span class="text-gray-700 text-sm">
          Página {{ pagina }} de {{ totalPaginas }}
        </span>
        <button
          @click="cambiarPagina(pagina + 1)"
          :disabled="pagina === totalPaginas"
          class="px-3 py-1 rounded-md border bg-gray-100 hover:bg-gray-200 disabled:opacity-50"
        >
          ▶
        </button>
      </div>
    </div>

    <div
      v-if="mostrarFormulario"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div
        class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-3xl relative max-h-[90vh] overflow-y-auto"
      >
        <button
          @click="cerrarFormulario"
          class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl"
        >
          ✕
        </button>

        <div class="overflow-y-auto max-h-[80vh] pr-2">
          <FacturaForm :factura="facturaSeleccionada" @close="cerrarFormulario" />
        </div>
      </div>
    </div>
  </div>
</template>
