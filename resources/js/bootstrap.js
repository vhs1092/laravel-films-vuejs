import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import Navbar from './components/NavBar'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
import money from 'v-money';

Vue.use(money, { precision: 2 })
Vue.use(ElementUI, { locale })

const BASE_URL = process.env.MIX_APP_URL || 'http://localhost:8000'

window.axios = axios

Vue.config.productionTip = false

Vue.use(VueRouter)

Vue.component('Navbar', Navbar)

Vue.directive('focus', {
    inserted(el) {
        el.focus()
    }
})

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.localStorage.token
axios.defaults.baseURL = `${BASE_URL}/api/`
