<template>
	<el-container style="height: 100vh">
		<el-aside :class="{collapse:collapse}">
			<el-scrollbar>
				<div style="padding:10px 20px">
					<img src="https://placeimg.com/36/36/live" style="vertical-align:middle"/>
					<span v-text="$config.name" style="padding-left:10px"></span>
				</div>
				<NavMenu :collapse="collapse"></NavMenu>
			</el-scrollbar>
		</el-aside>

		<el-container>
			<el-header height="55px">
				<el-row>
					<el-col>
					</el-col>
					<el-col style="text-align:right">
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
			'log'
		];
		return pages.reduce((prev, key)=> {
			let capitalizeKey = key.charAt(0).toUpperCase() + key.slice(1);
			prev[key] = defineAsyncComponent({
				loader: () => import('../pages/app/'+ capitalizeKey +'.vue'),
				delay: 0,
				timeout: 3000,
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
width: 60px ;
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
