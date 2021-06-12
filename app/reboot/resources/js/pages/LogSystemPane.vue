<template>
	<el-row type="flex" justify="space-between">
		<el-col :span="12">
			<el-button-group>
				<el-button v-if="info.selections.length>0" type="danger" size="small" @click="confirmDelete">
					Delete
				</el-button>
			</el-button-group>
		</el-col>
		<el-col :span="12" style="text-align:right">
			<el-button-group>
				<el-button type="primary" size="small" :loading="info.loading" @click="getData" plain>
					<span v-if="info.loading">Loading</span>
					<i v-else class="el-icon-refresh"></i>
				</el-button>
				<Export :data="data" :filename="title"></Export>
			</el-button-group>
		</el-col>
	</el-row>

	<el-table
		height="400"
		:data="data"
		@selection-change="(sel)=>info.selections=sel"
		@sort-change="({prop,order})=>{options.sort=prop;options.order=order;getData()}"
		:default-sort="{prop:options.sort,order:options.order}"
		v-loading="info.loading">
		<el-table-column type="selection"></el-table-column>
		<el-table-column prop="level" label="Level" width="80" sortable="custom">
			<template #default="{row}">
				<el-tag v-text="row.level" size="small" :type="row.level=='error'?'danger':''" @click="getDetail(row)"></el-tag>
			</template>
		</el-table-column>
		<el-table-column prop="date" label="Date" width="100" sortable="custom">
			<template #default="{row}">
				{{ dayjs(row.date, 'datetime') }}
			</template>
		</el-table-column>
		<el-table-column prop="environment" label="Env" width="80" sortable="custom"></el-table-column>
		<el-table-column prop="context.message" label="Message" sortable="custom"></el-table-column>
	</el-table>

	<el-pagination
		v-model:currentPage="options.page"
		:page-sizes="[10,25,50,100]"
		:page-size="options.limit"
		:total="info.total"
		layout="prev, pager, next, sizes, total"
		@size-change="getData"
		@current-change="getData"
		background>
	</el-pagination>

	<el-drawer
		:title="title"
		v-model="info.drawer"
		size="60%">
		<el-scrollbar style="padding: 20px;max-height:calc(100vh - 45px)">
			<el-descriptions title="" direction="vertical" :column="1" size="small" border>
				<el-descriptions-item label="ID">{{ form.id }}</el-descriptions-item>
				<el-descriptions-item label="Level">{{ form.level }}</el-descriptions-item>
				<el-descriptions-item label="Date">{{ dayjs(form.date, 'datetime') }}</el-descriptions-item>
				<el-descriptions-item label="Environment">{{ form.environment }}</el-descriptions-item>
				<el-descriptions-item label="Context">
					<pre>{{ form.context }}</pre>
				</el-descriptions-item>
				<el-descriptions-item label="File Path">{{ form.file_path }}</el-descriptions-item>
				<el-descriptions-item label="Stack Traces">
					<pre>{{ form.stack_traces }}</pre>
				</el-descriptions-item>
			</el-descriptions>
		</el-scrollbar>
	</el-drawer>
</template>

<script>
	export default {
		props: ['title'],
		data() {
			return {
				endpoint: '/api/app/logsystem/',
				data: [],
				form: {},
				error: {},
				export: [
					'id',
					'level',
					'environment',
					'date',
					'context.message',
				],
				options: {
					id:'',
					sort:'date',
					order:'descending',
					page: 1,
					limit: 10,
				},
				info:{
					drawer: false,
					loading: true,
					selections: [],
				}
			};
		},
		mounted(){
			this.getData();
		},
		methods:{
			getData(){
				this.info.loading = true;
				var params = new URLSearchParams(removeEmpty(this.options));
				axios.get(this.url(this.endpoint) + 'read?' + params)
					.then(response=>{
						this.data = response.data.data;
						this.options.page = response.data.current_page;
						this.info.total = response.data.total;
					})
					.catch(error=>{
						this.$message({type: 'error', message: 'Gagal memuat data'});
					})
					.finally(()=>this.info.loading = false);
			},
			getDetail(prop){
				this.info.drawer = true;
				this.form = prop;
			},
			updateData(){

			},
			deleteData(id){
				axios.delete(this.url(this.endpoint)+id)
					.then(response=>{
						this.$message({type: 'success', message: 'Data berhasil dihapus'});
						this.getData();
					})
					.catch(error=>{
						this.$message({type: 'error', message: 'Data gagal dihapus'});
					});
			},
			confirmDelete(id){
				var id = id? id: this.selections.map(sel=>sel.id).join(',');
				this.$confirm('Anda yakin menghapus data?', 'Warning', {type: 'warning'})
				.then(() => {
					this.deleteData(id);
				})
				.catch(() => {
					this.$message({type: 'info', message: 'Hapus dibatalkan'});
				});
			},
		}
	};
</script>
