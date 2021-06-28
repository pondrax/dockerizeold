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
				page: window.location.hash.split('/')[1]||'dashboard',
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
				route   	= '#!/' + route;
				this.page 	= route.split('/')[1];
				window.location.hash = route;
			},
			setSegmentPath(segment){
				console.log(segment);
				segment 	= segment.replace(' ', '-');
				window.location.hash = '#!/' + this.page + '/' + segment.toLowerCase();
			}
		}
	};
</script>
