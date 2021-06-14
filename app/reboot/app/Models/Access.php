<?php

namespace App\Models;

use App\Models\Base\Model;

class Access extends Model
{
    protected $table = 'app_access';

    protected $guarded = [];

    const rules = [
        'create' => [
            'role_id'  => 'required',
            'route_id' => 'required',
        ],
        'update' => [],
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function route()
    {
        return $this->belongsTo('App\Models\Route');
    }
}
