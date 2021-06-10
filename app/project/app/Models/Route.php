<?php

namespace App\Models;

use App\Models\Base\Model;

class Route extends Model 
{
	protected $table = 'app_route';
	
	protected $guarded = [];
	
	const rules = [
		'create' => [
			'menu_id' => 'required',
			'route'   => 'required',
			'method'  => 'required',
		],
		'update' => [
			'menu_id' => 'required',
		]
	];
	
	public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }

}
