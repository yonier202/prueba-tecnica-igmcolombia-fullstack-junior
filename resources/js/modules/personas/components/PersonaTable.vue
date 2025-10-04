<script setup>
import { ref, computed, onMounted } from "vue";
import { usePersonaStore } from "../stores/persona";

const emit = defineEmits(["editar"]);
const personaStore = usePersonaStore();

onMounted(() => {
  personaStore.fetchPersonas();
});

const searchQuery = ref("");

const filteredPersonas = computed(() => {
  return personaStore.personas.filter((p) =>
    `${p.nombres} ${p.apellidos} ${p.documento} ${p.email}`
      .toLowerCase()
      .includes(searchQuery.value.toLowerCase())
  );
});


const currentPage = ref(1);
const itemsPerPage = 5;
const totalPages = computed(() =>
  Math.ceil(filteredPersonas.value.length / itemsPerPage)
);
const paginatedPersonas = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredPersonas.value.slice(start, start + itemsPerPage);
});

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};
const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};
</script>

<template>
  <div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-3">
      <h2 class="text-lg font-semibold">Personas Registradas</h2>
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Buscar..."
        class="border rounded-md p-2 w-64"
      />
    </div>

    <table class="w-full text-left border-collapse">
      <thead>
        <tr class="border-b bg-gray-100">
          <th class="p-2">Nombre</th>
          <th>Documento</th>
          <th>Email</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="p in paginatedPersonas"
          :key="p.id"
          class="border-b hover:bg-gray-50"
        >
          <td class="p-2">{{ p.nombres }} {{ p.apellidos }}</td>
          <td>{{ p.tipo_documento }} {{ p.documento }}</td>
          <td>{{ p.email }}</td>
          <td>{{ p.telefono }}</td>
          <td class="space-x-2">
            <button class="text-blue-500 bg-indigo-100 rounded p-2" @click="emit('editar', p)">Editar</button>
            <button class="text-red-500 bg-red-100 rounded p-2" @click="personaStore.eliminarPersona(p.id)">Eliminar</button>
          </td>
        </tr>

        <tr v-if="!paginatedPersonas.length">
          <td colspan="5" class="text-center p-4 text-gray-500">
            No hay resultados
          </td>
        </tr>
      </tbody>
    </table>

    <div class="flex justify-center items-center gap-3 mt-4">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="px-3 py-1 border rounded-md bg-indigo-100"
      >
        Anterior
      </button>

      <span>Página {{ currentPage }} de {{ totalPages }}</span>

      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="px-3 py-1 border rounded-md bg-indigo-100"
      >
        Siguiente
      </button>
    </div>
  </div>
</template>
