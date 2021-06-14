<?php

namespace App\Models\Base;

use App\Models\Base\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Model extends BaseModel
{
	use HasFactory, SoftDeletes;

	protected $hidden 	= ['password','deleted_at'];
	protected $perPage 	= 10;
	protected $dates 	= ['created_at', 'updated_at', 'deleted_at'];

	protected static $rules 			= [];
	protected static $customMessage 	= [];
	protected static $customAttribute 	= [];

	public static function validate($request, $method, $id = null){
		$rules = static::$rules[$method];
		if($id){
			foreach($rules as $key=>$rule){
				$rules[$key] = str_replace(':id', $id, $rule);
			}
		}
		return \Validator::validate($request->all(), $rules, static::$customMessage, static::$customAttribute);
	}

	public function newEloquentBuilder($query){
		return new Builder($query);
	}
}
