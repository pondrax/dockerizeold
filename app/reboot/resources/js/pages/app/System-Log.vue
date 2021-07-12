<template>
	<!-- Filter -->
	<el-form v-if="info.filter" class="filterbar" size="small" label-position="top" inline>
		<el-form-item label="Filter Level" :width="50">
			<el-select v-model="query['level']" placeholder="Level" filterable clearable>
				<el-option v-for="item in options.level.list" :label="item" :value="item"></el-option>
			</el-select>
		</el-form-item>
		<el-form-item label="Filter Date">
			<el-date-picker v-model="query['date']" type="date" placeholder="Date">
			</el-date-picker>
		</el-form-item>
		<el-form-item label="Filter Environment">
			<el-input v-model="query['env']" placeholder="Environment">
			</el-input>
		</el-form-item>
		<el-form-item label="Filter Message">
			<el-input v-model="query['message']" placeholder="Message">
			</el-input>
		</el-form-item>
	</el-form>

	<!-- Toolbar -->
	<el-row v-if="info.selections.length>0">
		<el-col :span="12">
			<div style="padding:5px 0">
				{{ info.selections.length }} {{ $t('message.selection') }}
			</div>
		</el-col>
		<el-col :span="12" style="text-align:right">
			<el-button @click="confirmDelete" type="danger" size="small" v-text="$t('button.delete')" plain></el-button>
		</el-col>
	</el-row>
	<el-row v-else>
		<el-col :xs="24" :md="12">
		</el-col>
		<el-col :xs="24" :md="12" style="text-align:right">
			<el-button-group>
				<el-tooltip :content="$t('button.refresh')">
					<el-button type="primary" size="small" :loading="info.loading" @click="getData" icon="el-icon-refresh" plain>
					</el-button>
				</el-tooltip>
				<el-tooltip :content="$t('button.filter')">
					<el-button type="primary" size="small" @click="info.filter=!info.filter" icon="el-icon-collection-tag" plain>
					</el-button>
				</el-tooltip>
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
		@size-change="sizeChange">
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
					level: {
						list: [
							'emergency',
							'alert',
							'critical',
							'error',
							'warning',
							'notice',
							'info',
							'debug',
						]
					}
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
					filter: false,
					selections: [],
				}
			};
		},
		mounted(){
			this.getData();
			this.getSelectData();
		},
		watch:{
			query: {
				handler(val) {
					this.getData();
				},
				deep: true
			}
		},
		methods:{
			getDetail(prop){
				this.info.drawer = true;
				this.form = prop;
			},
		}
	};
</script>
