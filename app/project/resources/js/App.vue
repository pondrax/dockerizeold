<template>
	<Main></Main>
</template>

<script>

	import Main from './layouts/Main.vue';
	
	const mixins = {
		methods:{
			http(url){
				return axios(url);
			}
		}
	};
	
	export default {
		mixins: [mixins],
		data(){
			return {
				user: {
					name	: 'admin',
					email	: 'admin@project.test',
					photo	: 'https://placeimg.com/50/50/profile'
				},
				page: window.location.hash.split('/')[1] || 'dashboard',
			};
		},
		components: {
			Main,
		}
	};
</script>
