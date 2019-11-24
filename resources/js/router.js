import VueRouter from 'vue-router'

const routes = [
	{ path: '/', name: 'home', component: require('./pages/welcome.vue').default, meta: { auth: undefined } },
	{ path: '/register', name: 'register', component: require('./pages/auth/register.vue').default, meta: { auth: false } },
	{ path: '/login', name: 'login', component: require('./pages/auth/login.vue').default, meta: { auth: false } },
	{ path: '/dashboard', name: 'dashboard', component: require('./pages/home.vue').default, meta: { auth: true } },
	
	{ path: '/user', name: 'user', component: require('./pages/user/index.vue').default, meta: { auth: true } },
	{ path: '/role', name: 'role', component: require('./pages/role/index.vue').default, meta: { auth: true } },
	
	{ path: '*', component: require('./pages/errors/404.vue').default, meta: { auth: undefined } }
]

const router = new VueRouter({
	history: true,
	mode: 'history',
	routes,
});

export default router
