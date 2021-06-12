<?php

namespace App\Models\Base;

use App\Models\Base\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Model extends BaseModel
{
	use HasFactory;

	public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
