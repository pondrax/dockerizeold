const collections = {
	user : {
		route: [
			//Auth
			{
				method :'POST',
				route : '/api/auth/login',
				body : {
					username : 'drax',
					password : 'lumen123'
				}
			},
			{
				method :'POST',
				route : '/api/auth/register',
				body : {
					username : 'test',
					email	 : 'test@mail.com',
					password : 'lumen123',
				}
			},

			// Role
			{
				method :'GET',
				route : '/api/app/role/read',
			},
			{
				method :'POST',
				route : '/api/app/role',
				body : {
					role : 'Role name',
					description	 : 'Role description',
				}
			},
			{
				method :'PUT',
				route : '/api/app/role/5',
				body : {
					role : 'Role name edit',
					description	 : 'Role description edit',
				}
			},
			{
				method :'DELETE',
				route : '/api/app/role/5'
			},

			// User
			{
				method :'GET',
				route : '/api/app/user/read',
			},
			{
				method :'POST',
				route : '/api/app/user',
				body : {
					name : 'user name',
					email : 'user@email.com',
					password : '12345678',
				}
			},
			{
				method :'PUT',
				route : '/api/app/user/5',
				body : {
					user : 'user name edit',
					description	 : 'user description edit',
				}
			},
			{
				method :'DELETE',
				route : '/api/app/user/5'
			},

			// Menu
			{
				method :'GET',
				route : '/api/app/menu/read',
			},
			{
				method :'POST',
				route : '/api/app/menu',
				body : {
					menu : 'menu name',
					description	 : 'menu description',
				}
			},
			{
				method :'PUT',
				route : '/api/app/menu/5',
				body : {
					menu : 'menu name edit',
					description	 : 'menu description edit',
				}
			},
			{
				method :'DELETE',
				route : '/api/app/menu/5'
			},

			// Route
			{
				method :'GET',
				route : '/api/app/route/read',
			},
			{
				method :'POST',
				route : '/api/app/route',
				body : {
					route : 'route name',
					description	 : 'route description',
				}
			},
			{
				method :'PUT',
				route : '/api/app/route/5',
				body : {
					route : 'route name edit',
					description	 : 'route description edit',
				}
			},
			{
				method :'DELETE',
				route : '/api/app/route/5'
			},

			// Route
			{
				method :'GET',
				route : '/api/app/log/read',
			},
			{
				method :'POST',
				route : '/api/app/route',
				body : {
					route : 'route name',
					description	 : 'route description',
				}
			},
			{
				method :'PUT',
				route : '/api/app/route/5',
				body : {
					route : 'route name edit',
					description	 : 'route description edit',
				}
			},
			{
				method :'DELETE',
				route : '/api/app/route/5'
			},
		],
	}
};
