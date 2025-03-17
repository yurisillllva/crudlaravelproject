import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';

// Importe apenas o CSS do Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css'

const app = createApp(App)

// Configure o Axios globalmente
app.config.globalProperties.$axios = axios.create({
  baseURL: 'http://localhost:8000/api'
})

app.mount('#app')