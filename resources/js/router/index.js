import VueRouter from 'vue-router'
import store from '../store'
import Home from '../components/Dashboard.vue'
import CreateFilm from '../components/films/form.vue'
import ShowFilm from '../components/films/show.vue'
import indexFilm from '../components/films/index.vue'
import indexGenres from '../components/genres/index.vue'
import createGenres from '../components/genres/form.vue'
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
			name: 'create-film',
			component: CreateFilm,
			meta: {
				auth: true
			}
		},
		{
			path: '/films/:slug',
			name: 'show-film',
			component: ShowFilm,
			meta: {
				auth: true
			}
		},
		{
			path: '/genres',
			name: 'genres',
			component: indexGenres,
			meta: {
				auth: true
			}
		},
		{
			path: '/genres/create',
			name: 'create-genre',
			component: createGenres,
			meta: {
				auth: true
			}
		},
		{
			path: '/genres/edit/:uuid',
			name: 'edit-genre',
			component: createGenres,
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