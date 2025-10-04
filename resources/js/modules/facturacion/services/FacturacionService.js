import api from '../../../lib/axios'

export default {
    permisosNav(id){
        return api.get('/permisos/'+id)
    },

    getAll() {
        return api.get('/facturas');
    },
    create(data) {
        return api.post('/facturas', data, {
        headers: { "Content-Type": "multipart/form-data" },
        });
    },
    update(id, data) {
        return api.post(`/facturas/${id}`, data, {
        headers: { "Content-Type": "multipart/form-data" },
        });
    },
    delete(id) {
        return api.delete(`/facturas/${id}`);
    },


}
