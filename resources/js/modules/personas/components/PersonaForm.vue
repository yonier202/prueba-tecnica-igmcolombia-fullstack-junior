<script setup>
import { reactive, watch, computed } from "vue";
import { usePersonaStore } from "../stores/persona";

const props = defineProps({
  personaSeleccionada: { type: Object, default: null },
});

const emit = defineEmits(["guardado"]);

const personaStore = usePersonaStore();

const limpiarFormulario = () => {
  Object.assign(form, {
    id: null,
    nombres: "",
    apellidos: "",
    tipo_documento: "CC",
    documento: "",
    email: "",
    telefono: "",
  });
};

const form = reactive({
  id: null,
  nombres: "",
  apellidos: "",
  tipo_documento: "CC",
  documento: "",
  email: "",
  telefono: "",
});

watch(
  () => props.personaSeleccionada,
  (persona) => {
    if (persona) Object.assign(form, persona);
    else limpiarFormulario();
  },
  { immediate: true }
);

const editMode = computed(() => !!form.id);
const guardarPersona = async () => {
  if (editMode.value) {
    await personaStore.actualizarPersona(form.id, form);
  } else {
    await personaStore.crearPersona(form);
  }
  emit("guardado");
  limpiarFormulario();
};

</script>

<template>
  <div class="bg-white shadow-md rounded-lg p-4 space-y-4">
    <h2 class="text-lg font-semibold">
      {{ editMode ? "Editar Persona" : "Registrar Persona" }}
    </h2>

    <form @submit.prevent="guardarPersona" class="grid grid-cols-2 gap-3">
      <input v-model="form.nombres" placeholder="Nombres" class="border rounded-md p-2 w-full" />
      <input v-model="form.apellidos" placeholder="Apellidos" class="border rounded-md p-2 w-full" />

      <select v-model="form.tipo_documento" class="border rounded-md p-2 w-full">
        <option value="CC">Cédula</option>
        <option value="TI">Tarjeta Identidad</option>
      </select>

      <input v-model="form.documento" placeholder="Número Documento" class="border rounded-md p-2 w-full" />
      <input v-model="form.email" placeholder="Email" class="border rounded-md p-2 w-full" />
      <input v-model="form.telefono" placeholder="Teléfono" class="border rounded-md p-2 w-full" />

      <div class="col-span-2 flex gap-2">
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg py-2 px-4"
        >
          {{ editMode ? "Actualizar" : "Guardar" }}
        </button>

        <button
          v-if="editMode"
          type="button"
          @click="limpiarFormulario"
          class="bg-gray-400 hover:bg-gray-500 text-white rounded-lg py-2 px-4"
        >
          Cancelar
        </button>
      </div>
    </form>
  </div>
</template>
