<?php

namespace App\Models;

use App\Models\Base\Model;

class Role extends Model
{
    /**
     * Configs
     */
    protected $table	= 'app_role';

    protected $hidden	= ['deleted_at'];
    protected $guard	= [];
    protected $appends	= [];
    protected $with		= [];
    protected $without	= [];


    /**
     * Rules
     */
    public static $rules = [
        'save' => [
            'role'			=> 'required|string',
            'description'	=> 'required|string',
        ],
	];


    /**
     * Mutators
     */


    /**
     * Assessor
     */


    /**
     * Relationships
     */
    public function user()
    {
        return $this->hasMany('App\Models\User');
    }

    public function access()
    {
        return $this->hasMany('App\Models\Access');
    }
}
