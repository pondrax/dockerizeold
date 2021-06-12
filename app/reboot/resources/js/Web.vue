<template>
	Web
</template>

<script>

	import Main from './layouts/Main.vue';
	
	export default {
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
