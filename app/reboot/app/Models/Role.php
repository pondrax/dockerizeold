<?php

namespace App\Models;

use App\Models\Base\Model;

class Role extends Model
{
    protected $table = 'app_role';

    protected $guarded = [];

    const rules = [
        'create' => [
            'role'        => 'required',
            'description' => 'required',
        ],
        'update' => [
            'role' => 'required',
            // 'description' => 'required'
        ],
    ];

    public function user()
    {
        return $this->hasMany('App\Models\User');
    }

    public function access()
    {
        return $this->hasMany('App\Models\Access');
    }
}
