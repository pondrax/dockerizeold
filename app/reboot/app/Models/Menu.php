<?php

namespace App\Models;

use App\Models\Base\Model;

class Menu extends Model
{
    /**
     * Configs
     */
    protected $table	= 'app_menu';

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
            'menu'			=> 'required|string',
            'icon'			=> 'required|string',
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
    public function route()
    {
        return $this->hasMany('App\Models\Route');
    }
}
