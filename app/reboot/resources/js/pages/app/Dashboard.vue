<template>
		<el-tabs v-model="tab">
			<el-tab-pane label="User" name="user">
				<div class="tab-card">
					<el-button @click="drawer = true" type="primary">
						open
					</el-button>
				</div>
			</el-tab-pane>
			<el-tab-pane label="Config" name="second">Config</el-tab-pane>
			<el-tab-pane label="Role" name="third">Role</el-tab-pane>
			<el-tab-pane label="Task" name="fourth">Task</el-tab-pane>
		</el-tabs>
		

	<el-drawer
		title="I am the title"
		v-model="drawer"
		:with-header="false"
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
				tab :'user'
			};
		}
	};
</script>
