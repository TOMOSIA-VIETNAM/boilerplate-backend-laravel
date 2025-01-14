import './bootstrap';

import { createApp } from 'vue';
import AdminApp from './components/App.vue';
import LoginForm from './pages/LoginForm.vue';

createApp(AdminApp).mount('#admin');
createApp(LoginForm).mount('#login');
