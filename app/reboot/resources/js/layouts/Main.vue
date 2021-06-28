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
						<keep-alive>
							<component :is='$root.page'></component>
						</keep-alive>
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
	import Loading from '../components/Loading.vue';
	import Error from '../components/Error.vue';

	import NavMenu from './NavMenu.vue';

	const Pages = ()=>{
		const pages = [
			'dashboard',
			'user',
			'role',
			'config',
			'manage',
			'log',
			'route',
			'menu',
		];
		return pages.reduce((prev, key)=> {
			let capitalizeKey = key.charAt(0).toUpperCase() + key.slice(1);
			prev[key] = defineAsyncComponent({
				loader: () => import('../pages/app/'+ capitalizeKey +'.vue'),
				errorComponent: Error,
				loadingComponent: Loading
			});
			return prev;
		}, {});
	}


	export default {
		data() {
			return {
				collapse:false
			};
		},
		components:{
			NavMenu,
			...Pages(),
		}
	};
</script>

<style scoped>
.el-header {
color: #333;
line-height: 50px;
border-bottom:1px #ddd solid;
background:#fff;
}
.el-aside {
width: 200px !important;
color: #DBDBDB;
background: rgb(84, 92, 100);
}
.el-aside.collapse {
width: 60px !important;
}
.el-aside .sidebar-title{
padding:10px 20px;
}
.el-aside.collapse .sidebar-title{
padding:10px 12px;
}
.el-aside.collapse .sidebar-title span{
display:none;
}
.el-main{
padding:0;
}
.el-footer{
margin:15px;
text-align:center;
color: #333;
font-size:12px;
}
</style>
