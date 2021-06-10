<template>
		<el-tabs v-model="activeName">
			<el-tab-pane label="User" name="user" class="tab-card">
				<el-button @click="drawer = true" type="primary">
					open
				</el-button>
				<el-button type="primary" :loading="true" size="small">Loading</el-button>
				
				{{ USER.options }}
				<el-table :data="USER.data" @selection-change="handleSelectionChange">
					<el-table-column type="selection" width="55">
					</el-table-column>
					<el-table-column property="name" label="Name">
					</el-table-column>
					<el-table-column property="email" label="Email">
					</el-table-column>
				</el-table>
				<el-pagination
					v-model:currentPage="USER.options.page"
					:page-sizes="[15,50,100,200]"
					:page-size="USER.options.per_page"
					:total="USER.property.total"
					layout="total, prev, pager, next, sizes"
					background
					style="padding:10px 0">
				</el-pagination>
			</el-tab-pane>
		</el-tabs>
		

	<el-drawer
		title="I am the title"
		v-model="drawer"
		size="50%">
		<el-container>
			<span>Hi there!</span>
		</el-container>
	</el-drawer>
</template>

<script>
	export default {
		data() {
			return {
				drawer: false,
				activeName :'user',
				
				USER:{
					data: [],
					selections: [],
					options: {
						id:'',
						user:'',
						filter_user:'',
						'filter_role.id':'',
						page: 1,
						limit: 10,
					},
					property:{
						loading: true,
						per_page: 10,
						from: 1,
						to: 1,
						total: 1000,
					}
				},
			};
		},
		mounted(){
			this.getTable();
		},
		methods:{
			getTable(){
				axios.get('https://jsonplaceholder.typicode.com/users')
					.then(response=>this.USER.data = response.data)
					.catch(error=>console.error(error))
					.finally(()=>console.log('end'));
			}
		}
	};
</script>
