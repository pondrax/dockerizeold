<template>
	<el-menu
		:collapse="collapse"
		default-active="1"
		text-color="#fff"
		background-color="#545c64"
		active-text-color="#ffd04b"
		style="border:0">
		<template v-for="(menu, m) in appMenu">
			<el-menu-item v-if="!menu.list" @click="setPath(menu.path)" index="(m+1).toString()">
				<template #title>
					<i :class="menu.icon"></i>
					<span v-text="menu.name"></span>
				</template>
			</el-menu-item>
			
			<el-submenu v-else :index="m.toString()">
				<template #title>
					<i :class="menu.icon"></i>
					<span v-text="menu.name"></span>
				</template>
				
				<el-menu-item v-for="(list, l) in menu.list" :index="(m+1)+'-'+(l+1)" @click="setPath(list.path)">
					<span v-text="list.name"></span>
				</el-menu-item>
			</el-submenu>
		</template>
	</el-menu>
</template>

<script>	
	const appMenu = [
		{ name:'Dashboard', icon:'el-icon-menu', path:'#!/dashboard/' },
		{ name:'Data', icon:'el-icon-s-data', list: [
			{ name: 'Data', path:'#!/data/' },
		]},
		{ name:'Management', icon: 'el-icon-setting', list: [
			{ name: 'User', path:'#!/user/' },
			{ name: 'Role', path:'#!/role/' },
			{ name: 'Logs', path:'#!/logs/' },
		]},
		{ name:'Developer', icon: 'el-icon-set-up', list: [
			{ name: 'Route', path:'#!/route/' },
			{ name: 'Menu', path:'#!/menu/' },
		]},
	];
	
	export default {
		props: ['collapse'],
		data() {
			return {
				appMenu: appMenu
			};
		},
		methods:{
			setPath(path){
				let page = path.split('/')[1];
				this.$root.page = page;
				window.location.hash = path;
			}
		}
	};
</script>
