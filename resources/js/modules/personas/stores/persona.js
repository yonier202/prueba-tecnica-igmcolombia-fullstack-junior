import { defineStore } from "pinia";
import personaService from "../Services/personaService";
import Swal from 'sweetalert2';

export const usePersonaStore = defineStore("persona", {
  state: () => ({
    personas: [],
    personaEncontrada: null,
    loading: false,
  }),

  actions: {
    async fetchPersonas() {
      this.loading = true;
      try {
        const { data } = await personaService.getAll();
        this.personas = data.data ?? data;
      } finally {
        this.loading = false;
      }
    },

    async Alerta(type, msj, icon){
        Swal.fire({
            title: type,
            text:  msj,
            icon: icon,
            confirmButtonText: 'Aceptar'
        });
    },


    async buscarPersona(tipo_documento, documento) {
      this.loading = true;
      try {
        const { data } = await personaService.buscarPorDocumento(tipo_documento, documento);
        this.personaEncontrada = data;
      } catch {
        this.personaEncontrada = null;
      } finally {
        this.loading = false;
      }
    },

    async crearPersona(data) {
      await personaService.create(data);
      await this.fetchPersonas();
      this.Alerta('Exito', 'Persona creada con exito', 'success');
    },

    async actualizarPersona(id, payload) {
        await personaService.update(id, payload);
        await this.fetchPersonas();
        this.Alerta('Exito', 'Persona Actulizada con exito', 'success');
    },

    async eliminarPersona(id) {
      await personaService.delete(id);
      this.personas = this.personas.filter((p) => p.id !== id);
    },
  },
});
