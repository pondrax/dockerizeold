<template>
	<el-dropdown>
		<el-tooltip :content="$t('button.export')" >
			<el-button type="primary" size="small" icon="el-icon-document" plain>
				<i class="el-icon-arrow-down el-icon--right"></i>
			</el-button>
		</el-tooltip>
		<template #dropdown>
			<el-dropdown-menu>
				<el-dropdown-item @click="download('csv')">CSV</el-dropdown-item>
				<el-dropdown-item @click="download('xls')">XLS</el-dropdown-item>
				<el-dropdown-item @click="download('json')">JSON</el-dropdown-item>
			</el-dropdown-menu>
		</template>
	</el-dropdown>
</template>

<script>
	import exportFromJSON from 'export-from-json';

	export default {
		props : ['data', 'filename'],
		methods:{
			download(type){
				//console.log(this.data, this.filename, type);
				exportFromJSON({
					data		: this.data,
					fileName	: this.filename,
					exportType	: type
				});
			}
		}
	};
</script>
