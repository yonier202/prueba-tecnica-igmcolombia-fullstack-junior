<script setup>
import { ref } from "vue";
import { usePersonaStore } from "../stores/persona";
import PersonaForm from "../components/PersonaForm.vue";
import PersonaTable from "../components/PersonaTable.vue";
import Header from '../../facturacion/components/Header.vue'

const personaStore = usePersonaStore();

const personaSeleccionada = ref(null);

const editarPersona = (persona) => {
  personaSeleccionada.value = { ...persona };
};

const onGuardado = async () => {
  personaSeleccionada.value = null;
  await personaStore.fetchPersonas();
};
</script>

<template>
    <div>
        <Header></Header>
    </div>
    <div class="space-y-6">

        <div class="mx-auto w-2/3">
            <PersonaForm
            :personaSeleccionada="personaSeleccionada"
            @guardado="onGuardado"
            />
        </div>


        <PersonaTable @editar="editarPersona" />
    </div>
</template>
