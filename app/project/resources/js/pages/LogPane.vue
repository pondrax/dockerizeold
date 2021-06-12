<template>
	<el-row type="flex" justify="space-between">
		<el-col :span="12">
			<el-button-group>
				<el-button v-if="property.selections.length>0" type="danger" size="small" @click="removeData">
					Delete
				</el-button>
			</el-button-group>
		</el-col>
		<el-col :span="12" style="text-align:right">
			<el-button-group>
				<el-button type="primary" size="small" :loading="property.loading" @click="getData" plain>
					<span v-if="property.loading">Loading</span>
					<i v-else class="el-icon-refresh"></i>
				</el-button>
				<Export :data="data" :filename="title"></Export>
			</el-button-group>
		</el-col>
	</el-row>

	<el-table :data="data" @selection-change="setSelection" height="400" v-loading="property.loading">
		<el-table-column type="selection"></el-table-column>
		<el-table-column property="level" label="level" width="80">
			<template #default="scope">
				<el-button v-text="scope.row.level" size="mini" :type="scope.row.level"></el-button>
			</template>
		</el-table-column>
		<el-table-column property="date" label="date" width="100">
			<template #default="scope">
				{{ $dayjs(scope.row.date, 'datetime') }}
			</template>
		</el-table-column>
		<el-table-column property="context.message" label="message"></el-table-column>
	</el-table>

	<el-pagination
		v-model:currentPage="options.page"
		:page-sizes="[10,25,50,100]"
		:page-size="options.limit"
		:total="property.total"
		layout="prev, pager, next, sizes, total"
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
		props: ['title'],
		data() {
			return {
				endpoint: '/api/app/log/read',
				data: [],
				form: {},
				error: {},
				export: [],
				options: {
					id:'',
					sort:'id',
					order:'desc',
					page: 1,
					limit: 10,
				},
				property:{
					drawer: false,
					loading: true,
					selections: [],
				}
			};
		},
		mounted(){
			this.getData();
		},
		watch:{
			'options.page'(val){
				this.getData();
			},
			'options.limit'(val){
				this.getData();
			}
		},
		computed:{
		},
		methods:{
			getData(){
				this.property.loading = true;
				var params = new URLSearchParams(removeEmpty(this.options));
				var url = this.$config.url + this.endpoint + '?' + params;
				//console.log(url);
				axios.get(url)
					.then(response=>{
						this.data = response.data.data;
						this.options.page = response.data.current_page;
						this.property.total = response.data.total;
					})
					.catch(error=>{
						console.info(error);
						this.$message(error)
					})
					.finally(()=>this.property.loading = false);
			},
			setSelection(selections){
				this.property.selections = selections;
			}
		}
	};
</script>
