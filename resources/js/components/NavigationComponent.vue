<template>
	<div class="container">
		<span class="navbar-brand">V 6.2.0</span>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation'"><span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item" v-if="$auth.check()" v-for="(route, key) in routes.admin" v-bind:key="route.path">
					<router-link class="nav-link" :to="{ name : route.path }" :key="key">{{ route.name }}</router-link>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item" v-if="!$auth.check()" v-for="(route, key) in routes.unlogged" v-bind:key="route.path">
					<router-link class="nav-link" :to="{ name : route.path }" :key="key">{{ route.name }}</router-link>
				</li>
				<li class="nav-item dropdown" v-if="$auth.check()">
					<a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img class="rounded-circle profile-photo mr-1">maulana saputra
					</a>
					<div class="dropdown-menu">
						<router-link class="dropdown-item pl-3" :to="{ name : 'settings' }">Settings</router-link>
						<div class="dropdown-divider"/>
						<a href="#" @click.prevent="$auth.logout()" class="dropdown-item pl-3">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</template>
<script>
	export default {
		data: function ()
		{
			return {
				routes: {
					unlogged: [
						{
							name: 'Register',
							path: 'register'
						},
						{
							name: 'Login',
							path: 'login'
						}
					],
					admin: [
						{
							name: 'Home',
							path: 'dashboard',
						},
						{
							name: 'User',
							path: 'user'
						},
						{
							name: 'Role',
							path: 'role'
						}
					]
				}
			}
		}
	}
</script>
