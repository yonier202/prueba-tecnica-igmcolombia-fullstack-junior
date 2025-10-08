import axios from 'axios';

const api = axios.create({
    baseURL: 'https://prueba-tecnica-igmcolombia-fullstack-junior-production.up.railway.app/api',
});

api.interceptors.request.use((config) => {
  const userString = localStorage.getItem("user");

  if (userString) {
    try {
      const user = JSON.parse(userString); // Parsear el JSON
      if (user?.token) {
        config.headers.Authorization = `Bearer ${user.token}`;
      }
    } catch (error) {
      console.error('Error parsing user from localStorage:', error);
    }
  }

  return config;
});

export default api;
