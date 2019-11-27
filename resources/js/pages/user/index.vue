<template>
	<div class="card card-default">
		<div class="card-header">
			List
		</div>
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="45%">Name</th>
						<th width="20%">Role</th>
						<th width="10%">Created</th>
						<th width="20%" class="text-center"><button class="btn btn-primary btn-sm" id="show-modal" @click="openModal('add')">add</button></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(data, index) in list.data">
						<td>#</td>
						<td>{{ data.name }}</td>
						<td>{{ data.roles[0].name }}</td>
						<td>{{ data.created_at }}</td>
						<td class="text-center">
							<button class="btn btn-primary btn-sm" id="show-modal" @click="openModal('edit', data.id)">edit</button>&nbsp;
							<button class="btn btn-danger btn-sm" @click="del(data.id)">del</button>
						</td>
					</tr>
				</tbody>
			</table>
			<pagination :data="list" @pagination-change-page="getPage"></pagination>
			<modal v-if="show_modal" @close="show_modal = false">
				<h3 slot="header" id="modal_title">custom header</h3>
				<div slot="body">
					<validation-errors :errors="validation_errors" v-if="validation_errors"></validation-errors>
					<div class="form-group">
						<label>name</label>
						<input class="form-control" type="text" v-model="user.name">
					</div>
					<div class="form-group">
						<label>email</label>
						<input class="form-control" type="text" v-model="user.email">
					</div>
					<div class="form-group" v-if="session_active == 'add'">
						<label>password</label>
						<input class="form-control" type="password" v-model="user.password">
					</div>
					<div class="form-group" v-if="session_active == 'add'">
						<label>confirm password</label>
						<input class="form-control" type="password" v-model="user.confirm_password">
					</div>
					<div class="form-group">
						<label>role</label>
						<select v-model="user.role">
							<option v-for="data in roles" v-bind:value="data.id">{{ data.name }}</option>
						</select>
					</div>
				</div>
				<div slot="footer">
					<button class="btn btn-primary" v-if="session_active == 'add'" @click="add()">Simpan</button>
					<button class="btn btn-primary" v-if="session_active == 'edit'" @click="update(id)">Update</button>
					&nbsp;
					<button class="btn btn-secondary" @click="show_modal = false">Close</button>
				</div>
			</modal>
		</div>
	</div>
</template>
<script>
	export default {
		data: function ()
		{
			return {
				list: [],
				id: '',
				user: {
					name: '',
					email: '',
					password: '',
					confirm_password: '',
					role: '',
				},
				roles: [],
				show_modal: false,
				session_active: 'add',
				validation_errors: '',
			}
		},
		mounted: function ()
		{
			this.getPage()
		},
		methods: {
			init: function ()
			{
				this.id = this.user.name = this.user.email = this.user.password = this.user.confirm_password = this.user.role = ''
			},
			getPage: function (page)
			{
				if (typeof page === 'undefined') page = 1
				
				axios.get('/user/page?page=' + page).then(response => {
					this.list = response.data
				}).catch(error => {
					alert(error.message)
				})
			},
			openModal: function (method, id)
			{
				this.session_active = method
				this.show_modal = true
				
				this.init()
				this.getRoles()
				
				if (method == 'add') {
					$('#modal_title').html('ADD USER')
				} else if (method == 'edit') {
					axios.get('user/edit/' + id).then(response => {
						this.user.name = response.data.name
						this.user.email = response.data.email
						this.user.role = response.data.roles[0].id
						
						this.id = id
						
						$('#modal_title').html('EDIT USER')
					}).catch(error => {
						alert(error.message)
					})
				} else {
					alert('Method not found !')
				}
			},
			getRoles: function ()
			{
				axios.get('roles/pluck').then(response => {
					this.roles = this.setRoles(response.data)
				}).catch(error => {
					alert(error.message)
				})
			},
			setRoles: function (roles)
			{
				if (!Object.keys(roles).length) return []
				
				var list = []
				Object.keys(roles).forEach(function (data) { list.push({'id': data, 'name': roles[data]}) })
				
				return list
			},
			add: function ()
			{
				axios.post('user/add', { 'name': this.user.name, 'email': this.user.email, 'password': this.user.password, 'confirm-password': this.user.confirm_password, 'role': this.user.role }, {credential: true}).then(response => {
					alert('berhasil di simpan')
					this.getPage()
					
					this.show_modal = false
				}).catch(error => {
					if (error.response.status == 422) {
						this.validation_errors = error.response.data.errors
					} else {
						alert('Connection error !')
					}
				})
			},
			update: function (id)
			{
				axios.post('user/update/' + id, { name: this.user.name, email: this.user.email, role: this.user.role }, {credential: true}).then(response => {
					alert('berhasil di update')
					this.getPage()
					
					this.show_modal = false
				}).catch(error => {
					if (error.response.status == 422) {
						this.validation_errors = error.response.data.errors
					} else {
						alert('Connection error !')
					}
				})
			},
			del: function (id)
			{
				axios.post('user/delete/' + id, {}, {credential: true}).then(response => {
					alert('berhasil di delete')
					this.getPage()
				}).catch(error => {
					alert('Connection error !')
				})
			}
		}
	}
</script>
