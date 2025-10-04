import { defineStore } from "pinia";
import RoleService from "../services/RolesService";

export const useRoleStore = defineStore("role", {
  state: () => ({
    roles: [],
  }),

  actions: {
    async fetchRoles() {
      try {
        const res = await RoleService.list();
        console.log(res);
        this.roles = res.data;
      } catch (error) {
        console.error("Error al obtener roles:", error);
      }
    },
  },
});
