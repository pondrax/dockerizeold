<template>
	<el-container style="height: 100vh">
		<el-aside :class="{collapse:collapse}">
			<el-scrollbar>
				<div class="sidebar-title">
					<img src="https://placeimg.com/36/36/live" style="vertical-align:middle"/>
					<span v-text="$config.name" style="padding-left:10px"></span>
				</div>
				<NavMenu :collapse="collapse"></NavMenu>
			</el-scrollbar>
		</el-aside>

		<el-container>
			<el-header height="55px">
				<el-row>
					<el-col :span="12">
						<el-button type="text" @click="collapse=!collapse">
							<i v-if="collapse" class="el-icon-s-unfold"></i>
							<i v-else class="el-icon-s-fold"></i>
						</el-button>
					</el-col>
					<el-col :span="12" style="text-align:right">
						<el-dropdown>
							<el-avatar :size="40" :src="$root.user.photo" style="vertical-align:middle"></el-avatar>
							<template #dropdown>
								<el-dropdown-menu>
									<div v-text="$root.user.email" style="padding:10px 20px 20px"></div>
									<el-dropdown-item>Profile</el-dropdown-item>
									<el-dropdown-item>Logout</el-dropdown-item>
								</el-dropdown-menu>
							</template>
						</el-dropdown>
					</el-col>
				</el-row>
			</el-header>
			<el-main>
				<el-scrollbar>
					<div style="min-height:75vh;padding:10px 20px">
						<el-tabs v-model="$root.page">
							<template v-for="pane,label in tabs" :key="label">
								<el-tab-pane :label="label.split('/')[1]" :name="label.toLowerCase()" class="tab-card">
									<keep-alive>
										<component :is="label" :title="label.split('/')[1]"></component>
									</keep-alive>
								</el-tab-pane>
							</template>
						</el-tabs>
					</div>
					<div class="el-footer">
						Copyright &copy;2021.
						{{ $config.name }} v{{ $config.version }}
					</div>
				</el-scrollbar>
			</el-main>
		</el-container>
	</el-container>
</template>

<script>
	import { defineAsyncComponent } from 'vue';

	const capitalize = (str)=>{
		return str.replace(/(^|[\s-])\S/g, function (match) {
			return match.toUpperCase();
		});
	}

	const pages = [
		/*'dashboard',
		'user',
		'role',
		'config',
		'manage',
		'Log',*/
		'dashboard/dashboard',
		'user/user',
		'role/role',
		'config/config',
		'manage/manage',
		'route/route',
		'route/system-log',
		'menu/menu',
	];

	const loadComponents = ()=>{
		return pages.reduce((prev, key)=> {
			let group   	= key.split('/')[0];
			let component 	= capitalize(key.split('/')[1]);

			prev[group + '/' + component] = defineAsyncComponent({
				loader: () => import('../pages/app/'+ component +'.vue'),
				errorComponent: require('../components/Error.vue').default,
				loadingComponent: require('../components/Loading.vue').default
			});
			return prev;
		}, {});
	}

	const components = loadComponents();
	//console.log(components);

	export default {
		components:{
			NavMenu	: require('./NavMenu.vue').default,
			...components
		},
		data() {
			return {
				components,
				collapse: window.innerWidth<=720
			};
		},
		created() {
			window.addEventListener("resize", this.resizeHandler);
		},
		unmounted() {
			window.removeEventListener("resize", this.resizeHandler);
		},
		computed:{
			tabs(){
				var components={};
				Object.keys(this.components).forEach(key=>{
					if(key.split('/')[0] == this.$root.page.split('/')[0]){
						components[key] = this.components[key];
					}
				});
				return components;
			}
		},
		methods:{
			resizeHandler(){
				this.collapse = window.innerWidth<=720;
			}
		}
	};
</script>
