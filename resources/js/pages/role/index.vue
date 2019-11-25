<template>
	<div class="card card-default">
		<div class="card-header">
			Data Role
		</div>
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="75%">Nama</th>
						<th width="20%" class="text-center"><button class="btn btn-primary btn-sm" id="show-modal" @click="openModal('add')">add</button></th>
						</tr>
				</thead>
				<tbody>
					<tr v-for="(data, index) in list.data">
						<td>#</td>
						<td>{{ data.name }}</td>
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
						<input class="form-control" type="text" v-model="role.name">
					</div>
					<div class="form-group">
						<label>permission</label>
						<div v-for="(data, index) in permission">
							<input type="checkbox" v-model="role.permission" v-bind:value="data.id" :id="data.id">&nbsp;<label :for="data.id">{{ data.name }}</label>
						</div>
					</div>
				</div>
				<div slot="footer">
					<button class="btn btn-primary" @click="add()" v-if="session_active == 'add'">Simpan</button>
					<button class="btn btn-primary" @click="update(id)" v-if="session_active == 'edit'">Update</button>
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
				list: {},
				permission: [],
				
				id: '',
				access: {},
				
				role: {
					name: '',
					permission: []
				},
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
				this.role.name = this.id = this.validation_errors = ''
				this.role.permission = this.access = []
			},
			getPage: function (page)
			{
				if (typeof page === 'undefined') page = 1
				
				axios.get('/roles/page?page=' + page).then(response => {
					this.list = response.data
				}).catch(error => {
					alert(error.message)
				})
			},
			openModal: function(method, id)
			{
				this.session_active = method
				this.show_modal = true
				this.init()
				
				axios.get('/roles/permission').then(response => {
					this.permission = response.data
					$('#modal_title').html('ADD ROLE')
				}).catch(error => {
					alert(error.message)
				})
				
				if (method == 'add') {
					$('#modal_title').html('ADD ROLE')
				} else if (method == 'edit') {
					axios.get('/roles/edit/' + id).then(response => {
						this.role.name = response.data.role.name
						this.access = response.data.access
						this.id = id
						
						if (this.access) this.onPermission(this.access)
						
						$('#modal_title').html('EDIT ROLE')
					}).catch(error => {
						alert(error.message)
					})
				} else {
					alert('Method not found !')
				}
			},
			onPermission: function (access)
			{
				var permission = this.permission
				var checked = []
				
				permission.forEach(function (data, index) {
					if (access[data.id] != undefined) checked.push(data.id)
				})
				
				this.role.permission = checked
			},
			add: function ()
			{
				axios.post('roles/add', { name: this.role.name, permission: this.role.permission }, {credential: true}).then(response => {
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
				axios.post('roles/update/' + id, { name: this.role.name, permission: this.role.permission }, {credential: true}).then(response => {
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
			del: function(id)
			{
				axios.post('roles/delete/' + id, {}, {credential: true}).then(response => {
					alert('berhasil di delete')
					this.getPage()
				}).catch(error => {
					alert(error.message)
				})
			}
		}
	}
</script>
