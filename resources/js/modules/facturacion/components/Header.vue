<script setup>
import { RouterLink } from "vue-router";
import { computed, onMounted } from "vue";
import { useAuthStore } from "../../auth/stores/auth";
import { useFacturacionStore } from "../stores/facturacion";
import img from '/public/img/facturacion.png'

const authStore = useAuthStore();
const facturacionStore = useFacturacionStore();

const isAdmin = computed(() => {
  return authStore.user.permisos === "admin";
});

onMounted(()=> {
    facturacionStore.navPermisos()
});

</script>

<template>
  <header class="bg-slate-700 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">

        <RouterLink :to='{ name: "facturacion" }' class="flex items-center space-x-3">
          <img :src="img" alt="Logo" class="h-10 w-10" />
          <span class="text-xl font-bold text-white">Facturación</span>
        </RouterLink>

        <nav class="flex space-x-6 text-white">
          <RouterLink
            :to="{ name: 'facturacion' }"
            class="hover:text-blue-400 font-medium transition"
            active-class="text-blue-400"
          >
            Facturación
          </RouterLink>

          <!-- Menú completo solo si tiene permisos -->
          <template v-if="isAdmin">
            <!-- Personas -->
            <RouterLink
              :to="{ name: 'personas' }"
              class="hover:text-blue-400 font-medium transition"
              active-class="text-blue-400"
            >
              Personas
            </RouterLink>

            <!-- Roles -->
            <RouterLink
              to="/roles"
              class="hover:text-blue-400 font-medium transition"
              active-class="text-blue-400"
            >
              Roles
            </RouterLink>
          </template>
        </nav>
      </div>
    </div>
  </header>
</template>
