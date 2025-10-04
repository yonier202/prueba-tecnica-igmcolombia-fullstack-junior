import { defineStore } from 'pinia'
import { ref, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import AuthService from '../services/AuthService'

export const useAuthStore = defineStore('auth', () => {
    const router = useRouter()

    const user = ref({
        data: null,
        token: '',
        permisos: ''
    })

    async function login(credentials) {
        try {
            const { data } = await AuthService.login(credentials)
            user.value.data = data.data
            user.value.token = data.token
            return true
        } catch (error) {
            console.error('Error al iniciar sesión:', error)
            throw error
        }
    }

    function logout() {
        user.value.data = null
        user.value.token = ''
        localStorage.removeItem('user')
        router.push('/login')
    }

    async function register(credentials) {
        try {
            const { data } = await AuthService.register(credentials)
            user.value.data = data.data
            user.value.token = data.token
            return true
        } catch (error) {
            console.error("Error al registrarse:", error)
            throw error
        }
    }

    function cargarLocalStorage() {
        const userData = localStorage.getItem('user')
        if (userData) {
            user.value = JSON.parse(userData)
        }
    }

    watch(user, (newUser) => {
        if (newUser && newUser.token) {
            localStorage.setItem('user', JSON.stringify(newUser))
        } else {
            localStorage.removeItem('user')
        }
    }, { deep: true })


    onMounted(() => {
        cargarLocalStorage()
        if (user.value?.token) {
            router.push('/facturacion')
        }
    })

    return {
        user,
        login,
        register,
        cargarLocalStorage,
        logout
    }
})
