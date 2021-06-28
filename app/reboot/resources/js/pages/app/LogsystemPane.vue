<template>
	<el-row type="flex" justify="space-between">
		<el-col :span="12">
			<el-button-group>
				<el-button v-if="info.selections" type="danger" size="small" @click="confirmDelete">
					{{ $t('button.delete') }}
				</el-button>
			</el-button-group>
		</el-col>
		<el-col :span="12" style="text-align:right">
			<el-button-group>
				<el-button type="success" size="small" :loading="info.loading" @click="getData" icon="el-icon-refresh" plain></el-button>
				<Export :data="data" :filename="title"></Export>
			</el-button-group>
		</el-col>
	</el-row>

	<el-table
		height="400"
		:data="data"
		@selection-change="selectionChange"
		@sort-change="sortChange"
		:default-sort="{prop:query.sort,order:query.order}"
		v-loading="info.loading">
		<el-table-column type="selection"></el-table-column>
		<el-table-column prop="level" label="Level" width="80" sortable="custom">
			<template #default="{row}">
				<el-tag v-text="row.level" size="small" :type="row.level=='error'?'danger':''" @click="getDetail(row)"></el-tag>
			</template>
		</el-table-column>
		<el-table-column prop="date" label="Date" width="100" sortable="custom">
			<template #default="{row}">
				{{ $d(row.date, 'long') }}
			</template>
		</el-table-column>
		<el-table-column prop="environment" label="Env" width="80" sortable="custom"></el-table-column>
		<el-table-column prop="context.message" label="Message" sortable="custom"></el-table-column>
	</el-table>

	<el-pagination
		v-model:currentPage="query.page"
		:page-size="query.limit"
		:total="info.total"
		layout="prev, pager, next, sizes, total"
		@size-change="getData"
		@current-change="getData">
	</el-pagination>

	<el-drawer
		:title="title"
		v-model="info.drawer"
		size="60%">
		<el-scrollbar style="padding: 20px;max-height:calc(100vh - 45px)">
			<el-descriptions title="" direction="vertical" :column="1" size="small" border>
				<el-descriptions-item label="ID">{{ form.id }}</el-descriptions-item>
				<el-descriptions-item label="Level">{{ form.level }}</el-descriptions-item>
				<el-descriptions-item label="Date">{{ $d(form.date) }}</el-descriptions-item>
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
				endpoint: 'app/logsystem/',
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
				options:{
				},
				query: {
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
			getDetail(prop){
				this.info.drawer = true;
				this.form = prop;
			},
		}
	};
</script>
