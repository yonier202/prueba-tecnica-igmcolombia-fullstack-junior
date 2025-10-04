<script setup>
import { onMounted } from "vue";
import { useRoleStore } from "../store/roles";

const roleStore = useRoleStore();

onMounted(() => {
  roleStore.fetchRoles();
});
</script>

<template>
  <div class="mx-auto bg-white shadow-md rounded-lg p-6 mt-8">
    <h2 class="text-2xl font-semibold mb-4 text-center text-gray-700">
      Lista de Roles
    </h2>

    <table class="min-w-full border border-gray-200 rounded-md">
      <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
        <tr>
          <th class="py-2 px-4 text-left border-b">ID</th>
          <th class="py-2 px-4 text-left border-b">Nombre</th>
          <th class="py-2 px-4 text-left border-b">Guard</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="role in roleStore.roles"
          :key="role.id"
          class="hover:bg-gray-50 text-gray-700"
        >
          <td class="py-2 px-4 border-b">{{ role.id }}</td>
          <td class="py-2 px-4 border-b">{{ role.name }}</td>
          <td class="py-2 px-4 border-b">{{ role.guard_name }}</td>
        </tr>
      </tbody>
    </table>

    <div v-if="!roleStore.roles.length" class="text-center py-4 text-gray-500">
      No hay roles registrados.
    </div>
  </div>
</template>
