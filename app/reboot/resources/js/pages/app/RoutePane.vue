<template>
	<!-- Filter -->
	<el-row>
	</el-row>

	<!-- Toolbar -->
	<el-row v-if="info.selections.length>0" class="toolbar">
		<el-col :span="12">
			<p>
				{{ info.selections.length }} {{ $t('message.selections') }}
			</p>
		</el-col>
		<el-col :span="12" style="text-align:right">
			<el-button-group>
				<el-button @click="confirmDelete" type="danger" size="small" v-text="$t('button.delete')" plain></el-button>
			</el-button-group>
		</el-col>
	</el-row>
	<el-row v-else>
		<el-col :span="12">
			<el-button-group>
				<el-tooltip :content="$t('button.add')">
					<el-button @click="getDetail" type="primary" size="small" icon="el-icon-plus" plain></el-button>
				</el-tooltip>
				<el-button @click="getDetail" type="primary" size="small" v-text="$t('button.generator')" plain></el-button>
			</el-button-group>
		</el-col>
		<el-col :span="12" style="text-align:right">
			<el-button-group>
				<el-button type="success" size="small" :loading="info.loading" @click="getData" icon="el-icon-refresh" plain></el-button>
				<Export :data="data" :filename="title"></Export>
			</el-button-group>
		</el-col>
	</el-row>

	<!-- Table -->
	<el-table
		height="400"
		:data="data"
		@selection-change="selectionChange"
		@sort-change="({prop,order})=>{query.sort=prop;query.order=order;getData()}"
		:default-sort="{prop:query.sort,order:query.order}"
		v-loading="info.loading">
		<el-table-column type="selection"></el-table-column>
		<el-table-column prop="method" label="Method" width="100" sortable="custom">
			<template #default="{row}">
				<el-tag v-text="row.method" size="mini"></el-tag>
			</template>
		</el-table-column>
		<el-table-column prop="route" label="Route" sortable="custom"></el-table-column>
		<el-table-column prop="uses" label="Uses" sortable="custom"></el-table-column>
		<el-table-column label="#" width="100">
			<template #default="{row}">
				<el-tooltip :content="$t('button.edit')" >
					<el-button @click="getDetail(row)" size="small" type="primary" icon="el-icon-edit" circle></el-button>
				</el-tooltip>
				<el-tooltip v-if="row.deletable" :content="$t('button.delete')" >
					<el-button @click="confirmDelete(row.id)" size="small" type="danger" icon="el-icon-delete" circle></el-button>
				</el-tooltip>
			</template>
		</el-table-column>
	</el-table>

	<!-- Pagination -->
	<el-pagination
		v-model:currentPage="query.page"
		:page-size="query.limit"
		:total="info.total"
		layout="prev, pager, next, sizes, total"
		@size-change="getData"
		@current-change="getData">
	</el-pagination>

	<!-- Drawer -->
	<el-drawer
		:title="title"
		v-model="info.drawer"
		size="60%">
		<el-scrollbar style="padding: 20px;max-height:calc(100vh - 45px)">
			<el-form label-width="150px" @input="validateData">
				<el-form-item label="Menu" :error="error.menu_id">
					<el-select v-model="form.menu_id" placeholder="Menu" filterable>
						<el-option v-for="item in options.menu.list" :label="item.menu" :value="item.id"></el-option>
					</el-select>
				</el-form-item>
				<el-form-item label="Route" :error="error.route">
					<el-input v-model="form.route" placeholder="Route"></el-input>
				</el-form-item>
				<el-form-item label="Method" :error="error.method">
					<el-select v-model="form.method" placeholder="Method" filterable>
						<el-option v-for="item in options.method.list" :label="item" :value="item"></el-option>
					</el-select>
				</el-form-item>
				<el-form-item label="Uses" :error="error.uses">
					<el-input v-model="form.uses" placeholder="Uses"></el-input>
				</el-form-item>
				<el-form-item label="Prefix" :error="error.prefix">
					<el-input v-model="form.prefix" placeholder="Prefix"></el-input>
				</el-form-item>
				<el-form-item label="Middleware" :error="error.middleware">
					<el-input v-model="form.middleware" placeholder="Middleware"></el-input>
				</el-form-item>
				<el-form-item label="Data" :error="error.data">
					<el-input v-model="form.data" type="textarea" placeholder="Data"></el-input>
				</el-form-item>
				<el-form-item>
					<el-button v-text="$t('button.save')" type="primary" @click="updateData"></el-button>
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
				options:{
					menu: {
						endpoint: 'app/menu/read',
						query	: '?field:menu_id,menu',
						list	: []
					},
					method: {
						list: ['GET','POST','PUT','DELETE']
					}
				},
				query: {
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
			this.getSelectData();
		},
		methods:{
		}
	};
</script>
