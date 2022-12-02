import Vue from 'vue'
import './bootstrap'
import RegisterComponent from "./components/RegisterComponent";
import vuetify from './plugins/vuetify/index' // path to vuetify export
import 'vuetify/dist/vuetify.min.css';

Vue.use(vuetify)

new Vue({
    components: { RegisterComponent },
}).$mount('#app');
