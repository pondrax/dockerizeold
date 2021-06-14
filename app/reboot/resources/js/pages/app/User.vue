<template>
		<el-tabs v-model="active">
			<el-tab-pane label="User" name="USER" class="tab-card">
				<UserPane></UserPane>
			</el-tab-pane>
		</el-tabs>
		
</template>

<script>
	import UserPane from './UserPane.vue';
	
	export default {
		data() {
			return {
				active :'USER',
			}
		},
		components: {
			UserPane,
		}
	};
</script>
