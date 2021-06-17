<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $perPage	= 10;
    protected $dates	= ['created_at', 'updated_at', 'deleted_at'];

    protected static $rules = [];
    protected static $customMessage = [];
    protected static $customAttribute = [];

	protected static function boot()
    {
        parent::boot();

        static::retrieved(function($model) {
			//var_dump($model->id);
        });

        static::retrieved(function($model) {
			//var_dump($model->id);
        });

        static::created(function($model) {
			//var_dump($model->id);
        });

        static::updated(function($model) {
			//var_dump($model->id);
        });

        static::deleting(function($model) {
			//var_dump($model);
			//die();
        });
    }


    public static function validate($request, $method, $id = null)
    {
        $rules = static::$rules[$method];
		foreach ($rules as $key=>$rule) {
			// if has ID (update) modify set unique value & skip required
			if($id != null){
				$rule = str_replace(['required',':id'], ['',$id], $rule);
			}else{
				$rule = str_replace(',:id', '', $rule);
			}
			$rules[$key] = trim(str_replace('||', '|', $rule), '|');
        }
        return \Validator::validate($request->all(), $rules, static::$customMessage, static::$customAttribute);
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
