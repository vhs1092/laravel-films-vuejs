import VueRouter from 'vue-router'
import store from '../store'
import Home from '../components/Dashboard.vue'
import CreateFilm from '../components/films/form.vue'
import indexFilm from '../components/films/index.vue'
import Register from '../components/Register.vue'
import Login from '../components/Login.vue'

const router = new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/',
			name: 'Home',
			component: Home,
			meta: {
				auth: true
			}
		},
		{
			path: '/films',
			name: 'films',
			component: indexFilm,
			meta: {
				auth: true
			}
		},
		{
			path: '/films/create',
			name: 'Create Film',
			component: CreateFilm,
			meta: {
				auth: true
			}
		},
		{
			path: '/register',
			name: 'Register',
			component: Register,
			meta: {
				auth: false
			}
		},
		{
			path: '/login',
			name: 'Login',
			component: Login,
			meta: {
				auth: false
			}
		},
		{
			path: '*',
			redirect: '/'
		}
	]
});

router.beforeEach((to, from, next) => {
	if (!store.getters.isLogged && to.meta.auth) {
		return next('/login')
	}

	if (store.getters.isLogged && to.name === 'Login') {
		return next('/')
	}

	next()
})

export default router