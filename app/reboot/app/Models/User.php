<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable;
    use Authorizable;
    use Notifiable;

    /**
     * Configs
     */
    protected $table	= 'app_user';

    protected $hidden 	= ['password','deleted_at'];
    protected $guard	= [];
    protected $appends	= [];
    protected $with		= ['role'];
    protected $without	= [];


    /**
     * Rules
     */
    public static $rules = [
		'register' => [
			'name'		=> 'required',
			'email'		=> 'required|email|unique:app_user,email:id',
			'password'	=> 'required|string|min:8',
		],
		'login' => [
			'name'		=> 'required|string',
			'password'	=> 'required|string',
		],
		'save' => [
			'name'		=> 'required',
			'email'		=> 'required|email|unique:app_user,email:id',
			'password'	=> 'required|string|min:8',
		],
	];


    /**
     * Mutators
     */
	public function setPasswordAttribute($value)
	{
		return $this->password = bcrypt($value);
	}


    /**
     * Assessor
     */


    /**
     * Relationships
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role')->withTrashed();
    }


    /**
     * Customs
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
