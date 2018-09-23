import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import Navbar from './components/NavBar'

const BASE_URL = process.env.BASE_URL || 'http://laravel-codeline.com'

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
