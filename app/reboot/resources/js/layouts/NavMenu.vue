<template>
	<el-menu
		:collapse="collapse"
		:default-active="$root.page"
		text-color="#fff"
		background-color="#545c64"
		active-text-color="#ffd04b"
		style="border:0">
		<template v-for="menu, m in appMenu">
			<el-submenu :index="m.toString()">
				<template #title>
					<i :class="menu.icon"></i>
					<span v-text="menu.name"></span>
				</template>
				<el-menu-item
					v-for="submenu,s in menu.submenu"
					:index="submenu.name.toLowerCase()"
					@click="$root.setPath(submenu.route_menu)">
					{{submenu.name}}
				</el-menu-item>
			</el-submenu>
		</template>
	</el-menu>
</template>

<script>
/*
	const appMenu = [
		{
			"name": "Dashboard",
			"icon": "el-icon-menu",
			"submenu": [
				{
					"name": "Dashboard",
					"route": []
				}
			]
		},
		{
			"name": "Management",
			"icon": "e-icon-setting",
			"submenu": [
				{
					"name": "User",
					"route": []
				},
				{
					"name": "Role",
					"route": []
				}

			]
		},
		{
			"name": "Developer",
			"icon": "e-icon-set-up",
			"submenu": [
				{
					"name": "Route",
					"route": []
				},
				{
					"name": "Menu",
					"route": []
				}
			]
		}
	];
*/
	export default {
		props: ['collapse'],
		data() {
			return {
				appMenu: [],
				route: 'app/route/collection'
			};
		},
		mounted(){
			this.getMenu();
		},
		methods:{
			getMenu(){
					this.http(this.url(this.route)+'?route:method=GET&limit=-1')
					.then(r=>{
						var appData = r.data.data['app'].data;

						var appMenu = [];
						appData.forEach(a=>{
							var menu = a.menu.split(' -> ');
							var tmp	= {
								name:menu[1],
								route: a.route,
								route_menu:
									menu[1].toLowerCase()
									+ '/'
									+ a.route[0].route.replace('app/','').split('{')[0]
							};
							// has top menu
							var index = appMenu.findIndex(m=>m.name == menu[0]);
							if(index>-1){
								appMenu[index].submenu.push(tmp);
							}else{
								appMenu.push({name:menu[0],icon:a.icon,submenu: [tmp]});
							}
						})
						console.log(appMenu);
						this.appMenu = appMenu
					})
			},
		}
	};
</script>
