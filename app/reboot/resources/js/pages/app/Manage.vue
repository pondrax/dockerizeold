<template>
	<el-tabs v-model="active">
		<template v-for="pane,label in components">
			<el-tab-pane :label="label" :name="label" class="tab-card">
				<component :is="label" :title="label"></component>
			</el-tab-pane>
		</template>
	</el-tabs>
</template>

<script>
	const components = {
		'Cache'     	: require('./CachePane.vue').default,
		//'Media'     	: require('./MediaPane.vue').default
	};

	export default {
		components,
		data() {
			return {
				active :'Cache',
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
