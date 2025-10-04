<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";

const authStore = useAuthStore();

const router = useRouter();

const email = ref("");
const password = ref("");
const error = ref("");

const handleLogin = async () => {
  error.value = "";

  try {
    await authStore.login({ email: email.value, password: password.value });
    router.push('/facturacion');
  } catch (e) {
    error.value = "Credenciales incorrectas";
  }
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-gray-100 to-blue-200">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
      <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-6">
        Iniciar Sesión
      </h1>

      <form @submit.prevent="handleLogin" class="space-y-5">

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">
            Correo
          </label>
          <input
            id="email"
            v-model="email"
            type="email"
            class="mt-1 block w-full rounded-lg border-2 border-blue-600 sm:text-sm p-4
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-700
                transition-all duration-200"
            required
            placeholder="correo@ejemplo.com"
          />
        </div>


        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">
            Contraseña
          </label>
          <input
            id="password"
            v-model="password"
            type="password"
            class="mt-1 block w-full rounded-lg border-2 border-blue-600 sm:text-sm p-4
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-700
                transition-all duration-200"
            required
            placeholder="********"
          />
        </div>


        <button
          type="submit"
          class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg
                 hover:bg-blue-700 focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 transition"
        >
          Entrar
        </button>
      </form>

      <p v-if="error" class="text-red-500 text-sm mt-4 text-center font-medium">
        {{ error }}
      </p>

      <!-- Link registro -->
      <p class="mt-6 text-sm text-gray-600 text-center">
        ¿No tienes cuenta?
        <RouterLink
          :to="{ name: 'register' }"
          class="text-blue-600 font-semibold hover:underline"
        >
          Regístrate aquí
        </RouterLink>
      </p>
    </div>
  </div>
</template>
