import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';

const app = createApp(App);

// Configurar Axios globalmente
app.config.globalProperties.$axios = axios.create({
  baseURL: 'http://localhost:8000/api', // URL do backend
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

app.mount('#app');