<?php

namespace App\Models;

use App\Models\Base\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

	protected $table = 'app_user';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    
    
	public function validate($data, $rule, $message, $index){
		$rules = [
			'register' => [
				'name'		=> 'required',
				'email'		=> 'required|email',
				'password'	=> 'required'
			],
			'login' => [
				'name' 		=> 'required|string',
				'password' 	=> 'required|string',
			],
			'create' => [],
			'update' => []
		];
		
		return $rulels['register'];
	}

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

}
