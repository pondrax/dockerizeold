<?php

namespace App\Models;

use App\Models\Base\Model;

class Route extends Model
{
    protected $table = 'app_route';

    protected $hidden = ['deletable'];
    protected $appends = [];
    protected $with = [];

    protected static $rules = [
        'create' => [
            'menu_id' => 'required',
            'route'   => 'required',
            'method'  => 'required',
        ],
        'update' => [
            'menu_id' => 'required',
        ],
    ];

    protected static $customMessage = [
        'required' => 'wajib oy',
    ];

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }
}
