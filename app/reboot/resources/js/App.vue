<template>
	<Main></Main>
</template>

<script>

	import Main from './layouts/Main.vue';

	const NotFoundComponent = { template: '<p>Page not found</p>' };

	export default {
		data(){
			return {
				user: {
					name	: 'admin',
					email	: 'admin@project.test',
					photo	: 'https://placeimg.com/50/50/profile'
				},
				page: window.location.hash.split('#')[0]||'dashboard',
			};
		},
		//created(){
		//	window.addEventListener('hashchange', () => console.log('hash change!'))
		//},
		components: {
			Main,
		},
		methods:{
			setPath(route){
				this.page = (route.split('/')[0]);

				//var menu = this.getUriMenu(menu);
				//console.log(route);
				window.location.hash = '#!/' +route; //+ this.getUriRouteClean(route);
			}
		}
	};
</script>
