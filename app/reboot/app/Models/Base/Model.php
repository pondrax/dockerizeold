<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden = ['password', 'deleted_at'];
    protected $perPage = 10;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected static $rules = [];
    protected static $customMessage = [];
    protected static $customAttribute = [];

    public static function validate($request, $method, $id = null)
    {
        $rules = static::$rules[$method];
		foreach ($rules as $key=>$rule) {
			if($id != null){
				$rule = str_replace(['required',':id'], ['',$id], $rule);
			}else{
				$rule = str_replace([',:id'], [''], $rule);
			}
			$rule = ltrim(str_replace('||', '|', $rule), '|');
			//d($rule, $key);
                //d($rule, $id);
			// if has ID (update) modify set unique value & skip required
			//if ($id) {
                //$rules[$key] = str_replace(['required', ':id'], ['', ','.$id], $rule);
            //}else{
                //$rules[$key] = str_replace(':id', '', $rule);
			//}
			$rules[$key] = $rule;
        }
		//d($id, $rules);
        return \Validator::validate($request->all(), $rules, static::$customMessage, static::$customAttribute);
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
