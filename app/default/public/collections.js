const collections = {
	user : [
		//Auth
		{
			method :'POST',
			url : '/api/auth/login',
			body : {
				username : 'drax',
				password : 'lumen123'
			}
		},
		{
			method :'POST',
			url : '/api/auth/register',
			body : {
				username : 'test',
				email	 : 'test@mail.com',
				password : 'lumen123',
			}
		},

		// Role
		{
			method :'GET',
			url : '/api/app/role/read',
		},
		{
			method :'POST',
			url : '/api/app/role',
			body : {
				role : 'Role name',
				description	 : 'Role description',
			}
		},
		{
			method :'PUT',
			url : '/api/app/role/5',
			body : {
				role : 'Role name edit',
				description	 : 'Role description edit',
			}
		},
		{
			method :'DELETE',
			url : '/api/app/role/5'
		},

		// User
		{
			method :'GET',
			url : '/api/app/user/read',
		},
		{
			method :'POST',
			url : '/api/app/user',
			body : {
				name : 'user name',
				email : 'user@email.com',
				password : '12345678',
			}
		},
		{
			method :'PUT',
			url : '/api/app/user/5',
			body : {
				user : 'user name edit',
				description	 : 'user description edit',
			}
		},
		{
			method :'DELETE',
			url : '/api/app/user/5'
		},

		// Menu
		{
			method :'GET',
			url : '/api/app/menu/read',
		},
		{
			method :'POST',
			url : '/api/app/menu',
			body : {
				menu : 'menu name',
				description	 : 'menu description',
			}
		},
		{
			method :'PUT',
			url : '/api/app/menu/5',
			body : {
				menu : 'menu name edit',
				description	 : 'menu description edit',
			}
		},
		{
			method :'DELETE',
			url : '/api/app/menu/5'
		},

		// Route
		{
			method :'GET',
			url : '/api/app/route/read',
		},
		{
			method :'POST',
			url : '/api/app/route',
			body : {
				route : 'route name',
				description	 : 'route description',
			}
		},
		{
			method :'PUT',
			url : '/api/app/route/5',
			body : {
				route : 'route name edit',
				description	 : 'route description edit',
			}
		},
		{
			method :'DELETE',
			url : '/api/app/route/5'
		},

		// Route
		{
			method :'GET',
			url : '/api/app/log/read',
		},
		{
			method :'POST',
			url : '/api/app/route',
			body : {
				route : 'route name',
				description	 : 'route description',
			}
		},
		{
			method :'PUT',
			url : '/api/app/route/5',
			body : {
				route : 'route name edit',
				description	 : 'route description edit',
			}
		},
		{
			method :'DELETE',
			url : '/api/app/route/5'
		},
	],
};
