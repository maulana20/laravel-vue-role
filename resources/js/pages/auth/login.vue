<template>
	<div class="container">
		<div class="card card-default">
			<div class="card-header">Login</div>
			<div class="card-body">
				<div class="alert alert-danger" v-if="has_error">
					<p>error, imposible</p>
				</div>
				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="email" class="form-control" placeholder="test@example.com" v-model="email">
				</div>
				<div class="form-group">
					<label form="password">Password</label>
					<input type="password" class="form-control" v-model="password">
				</div>
				<button type="submit" class="btn btn-primary" @click="login()">Login</button>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data: function ()
		{
			return {
				email: '',
				password: '',
				has_error: false
			}
		},
		methods:
		{
			login: function ()
			{
				this.$auth.login({
					data: {
						email: this.email,
						password: this.password,
					},
					success: function ()
					{
						console.log(this.$auth.user().role)
						this.$router.push({name: 'dashboard'})
					},
					error: function (err)
					{
						this.has_error = true
					},
					rememberMe: true
				})
			}
		}
	}
</script>
