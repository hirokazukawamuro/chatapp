import './bootstrap';
import { createApp } from 'vue'
import router from '../router';
import Parent from './components/Parent.vue';
import Chat from './components/Chat.vue';
import List from './components/List.vue';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
const app = createApp(Parent)
app.component('Chat', Chat);
app.component('List', List);
app.use(router)
app.mount('#app')





