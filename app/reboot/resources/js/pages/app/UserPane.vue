<template>
	<el-button-group>
		<el-button type="primary" size="small"  @click="property.drawer = true">
			<i class="el-icon-plus"></i> Add
		</el-button>
		<el-button type="info" size="small" :loading="property.loading" @click="getData">
			<span v-if="property.loading">
				Loading
			</span>
			<i v-else class="el-icon-refresh"></i>
		</el-button>
	</el-button-group>
	
	<el-table :data="data" @selection-change="handleSelectionChange">
		<el-table-column type="selection"></el-table-column>
		<el-table-column property="name" label="Name"></el-table-column>
		<el-table-column property="email" label="Email"></el-table-column>
	</el-table>
	
	<el-pagination
		v-model:currentPage="options.page"
		:page-sizes="[15,50,100,200]"
		:page-size="options.per_page"
		:total="property.total"
		layout="total, prev, pager, next, sizes"
		background>
	</el-pagination>

	<el-drawer
		:title="title"
		v-model="property.drawer"
		size="40%">
		<div style="padding: 20px">
			<el-form :model="form" label-width="120px" size="medium">
				<el-form-item label="Name">
					<el-input v-model="form.name"></el-input>
				</el-form-item>
				<el-form-item label="Email">
					<el-input v-model="form.email"></el-input>
				</el-form-item>
				<el-form-item label="Password">
					<el-input type="password" v-model="form.password"></el-input>
				</el-form-item>
				<el-form-item label="Role">
					<el-select v-model="form.role_id" placeholder="Role">
						<el-option label="Zone one" value="shanghai"></el-option>
						<el-option label="Zone two" value="beijing"></el-option>
					</el-select>
				</el-form-item>
				<el-form-item>
					<el-button type="primary" @click="onSubmit">Save</el-button>
				</el-form-item>
			</el-form>
		</div>
	</el-drawer>
</template>

<script>
	export default {
		data() {
			return {
				title: 'User',
				endpoint: '/api/app/user/read',
				data: [],
				form: {},
				error: {},
				options: {
					id:'',
					user:'',
					filter_user:'',
					'filter_role.id':'',
					page: 1,
					limit: 10,
				},
				property:{
					drawer: false,
					loading: true,
					selections: [],
					from: 1,
					to: 1,
					per_page: 10,
					total: 1000,
				}
			};
		},
		mounted(){
			this.getData();
		},
		methods:{
			getData(){
				this.property.loading = true;
				var params = new URLSearchParams(removeEmpty(this.options));
				var url = this.$config.url + this.endpoint + '?' + params;
				console.log(url);
				axios.get(url)
					.then(response=>this.data = response.data)
					.catch(error=>console.error(error))
					.finally(()=>this.property.loading = false);
			}
		}
	};
</script>
