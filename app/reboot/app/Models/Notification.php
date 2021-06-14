<?php

namespace App\Models;

use App\Models\Base\Model;

class Logaudit extends Model
{
    /**
     * Configs
     */
    protected $table	= 'app_logaudit';

    protected $hidden	= [];
    protected $guard	= [];
    protected $appends	= [];
    protected $with		= [];
    protected $without	= [];


    /**
     * Rules
     */
    public static $rules = [
        'save' => [
            'menu_id' => 'required|integer',
            'route'   => 'required|string|unique:app_route,route',
            'method'  => 'required|string',
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
    //public function menu()
    //{
        //return $this->belongsTo('App\Models\User')->withTrashed();
    //}
}
