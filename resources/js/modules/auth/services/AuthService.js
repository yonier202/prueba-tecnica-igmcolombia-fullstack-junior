import api from '../../../lib/axios'

export default {
    login(data){
        return api.post('/login', data)
    },

    register(data){
        return api.post('/register', data)
    },

}
