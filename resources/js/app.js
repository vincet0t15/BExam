require('./bootstrap');

import { createApp } from 'vue';
import App from './App.vue'
import router from './router'


//---->sweet alert
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
})

window.Toast = Toast //--> use global sweet alert
//---->end sweet aler

createApp(App)
    .use(router)
    .mount('#app');
