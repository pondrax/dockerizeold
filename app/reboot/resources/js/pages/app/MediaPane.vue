<template>
	<el-row type="flex" justify="space-between">
		<el-col :span="12">
			<el-button-group>
				<el-button v-if="info.selections.length>0" type="danger" size="small" @click="confirmDelete">
					{{ $t('button.delete') }}
				</el-button>
			</el-button-group>
		</el-col>
		<el-col :span="12" style="text-align:right">
			<el-button-group>
				<el-button type="primary" size="small" :loading="info.loading" @click="getData" plain>
					<span v-if="info.loading" v-text="$t('message.loading')"></span>
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
		<el-table-column prop="method" label="Method" width="100" sortable="custom">
			<template #default="{row}">
				<el-tag v-text="row.method" size="mini"></el-tag>
			</template>
		</el-table-column>
		<el-table-column prop="route" label="Route" sortable="custom"></el-table-column>
		<el-table-column prop="uses" label="Uses" sortable="custom"></el-table-column>
		<el-table-column label="#">
			<template #default="{row}">
				<el-button @click="getDetail(row)" size="small" type="">{{ $t('button.edit') }}</el-button>
				<el-button @click="confirmDelete(row.id)" size="small" type="danger">{{ $t('button.delete') }}</el-button>
			</template>
		</el-table-column>
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
			<el-form label-position="top" label-width="100px" size="small">
				<el-form-item label="Route">
					<el-input v-model="form.name"></el-input>
				</el-form-item>
				<el-form-item label="Method">
					<el-input v-model="form.method"></el-input>
				</el-form-item>
				<el-form-item label="Uses">
					<el-input v-model="form.uses"></el-input>
				</el-form-item>
			</el-form>
		</el-scrollbar>
	</el-drawer>
</template>

<script>
	export default {
		props: ['title'],
		data() {
			return {
				endpoint: 'app/route',
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
					sort:'id',
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
	};
</script>
