<template>
	<el-tabs v-model="active">
		<el-tab-pane label="Audit Log" name="audit" class="tab-card">
			<LogauditPane title="Audit Log"></LogauditPane>
		</el-tab-pane>
		<el-tab-pane label="System Log" name="system" class="tab-card">
			<LogSystemPane title="System Log"></LogSystemPane>
		</el-tab-pane>
		<el-tab-pane label="Schedule Log" name="chedule" class="tab-card">
			<LogSystemPane title="System Log"></LogSystemPane>
		</el-tab-pane>
	</el-tabs>
</template>

<script>
	import LogauditPane from './LogauditPane.vue';
	import LogSystemPane from './LogsystemPane.vue';

	export default {
		data() {
			return {
				active :'system',
			}
		},
		components: {
			LogauditPane,
			LogSystemPane,
		}
	};
</script>
