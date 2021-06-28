<template>
	<el-tabs v-model="active">
		<template v-for="pane,label in components" :key="label">
			<el-tab-pane :label="label" :name="label" class="tab-card">
				<component :is="label" :title="label"></component>
			</el-tab-pane>
		</template>
	</el-tabs>
</template>

<script>
	const components = {
		'Route'     	: require('./RoutePane.vue').default,
		'System Log'	: require('./LogsystemPane.vue').default
	};

	export default {
		components,
		data() {
			return {
				active :'Route',
				components
			}
		},
		watch:{
			active(label){
				this.$root.setSegmentPath(label);
			}
		}
	};
</script>
