import api from '../../../lib/axios'

export default {
  getAll() {
    return api.get('/personas');
  },
  create(data) {
    return api.post('/personas', data);
  },
  update(id, data) {
    return api.put(`/personas/${id}`, data);
  },
  delete(id) {
    return api.delete(`/personas/${id}`);
  },
  buscarPorDocumento(tipo_documento, numero_documento) {
    return api.post(`/buscar`, { tipo_documento, numero_documento });
  },
};
