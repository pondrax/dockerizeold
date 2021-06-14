<?php

namespace App\Models;

use App\Models\Base\Model;

class Route extends Model
{
    /**
     * Configs
     */
    protected $table	= 'app_route';

    protected $hidden	= ['deletable','deleted_at'];
    protected $guarded	= [];
    protected $appends	= [];
    protected $with		= [];
    protected $without	= [];


    /**
     * Rules
     */
    public static $rules = [
        'save' => [
            'menu_id'		=> 'required|integer',
            'route'			=> 'required|string|unique:app_route,route,:id',
            'method'		=> 'required|string',
            'uses'			=> 'required|string',
            'prefix'		=> 'required|string',
            'middleware'	=> 'required|string',
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
    public function menu()
    {
        return $this->belongsTo('App\Models\Menu')->withTrashed();
    }
}
