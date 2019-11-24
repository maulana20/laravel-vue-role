<template>
	<div class="card card-default">
		<div class="card-header">
			List
		</div>
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama</th>
						<th>Created</th>
						<th>Updated</th> 
					</tr>
				</thead>
				<tbody>
					<tr v-for="(user, index) in list.data">
						<td>#</td>
						<td>{{ user.name }}</td>
						<td>{{ user.created_at }}</td>
						<td>{{ user.updated_at }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>
<script>
	export default {
		data: function ()
		{
			return {
				list: {},
				validation_errors: '',
			}
		},
		mounted: function ()
		{
			this.getPage()
		},
		methods: {
			getPage: function (page)
			{
				if (typeof page === 'undefined') page = 1
				
				axios.get('/user/page?page=' + page).then(response => {
					console.log(response)
					this.list = response.data
				}).catch(error => {
					alert(error.message)
				})
			}
		}
	}
</script>
