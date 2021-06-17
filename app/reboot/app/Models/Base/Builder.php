<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

class Builder extends BaseBuilder
{
    private $functions = [
        'sort',
        'order',
        'limit',
        'page',
        'fields',
        'with',
        'without',
    ];

    private $separators = [
        '-not'		    => '<>',
        '-not-like'	=> 'not ilike',
        '-like'		   => 'ilike',
        '-more'		   => '>=',
        '-less'		   => '<=',
        '-min'		    => '>',
        '-max'		    => '<',
        '-between'	 => 'between',
    ];

    private $casts = [
        ':date'		=> 'date',
    ];

    public function filtering()
    {
        $collections = $this;
        $filters = request()->all();
        //var_dump($filters);
        $where = [
            'has' 	 => [],
            'where'	=> [],
        ];
        foreach ($filters as $key=>$val) {
            if (in_array($key, $this->functions)) {
                continue;
            }

            // Set default separator
            $separator = '=';
            foreach ($this->separators as $keySep=>$sep) {
                // if key has separator
                if (stristr($key, $keySep)) {
                    $separator = $sep;
                    $key = str_replace(array_keys($this->separators), '', $key);
                }
            }

            // Extract values
            if (!empty($val)) {
                if (strstr($key, ':')) {
                    $relations = explode(':', $key);
                    list($relate, $key) = $relations;
                    $where['has'][$relate] = array_merge(
                        $where['has'][$relate] ?? [],
                        [$key => compact('key', 'separator', 'val')]
                    );
                } else {
                    $where['where'] = array_merge(
                        $where['where'] ?? [],
                        [$key => compact('key', 'separator', 'val')]
                    );
                }
            }
        }

        if (count($where['has']) > 0) {
            // each relateds
            foreach ($where['has'] as $related=>$whereRelatedKey) {
                $this->has($related);
                $this->with([$related=> function ($q) use ($whereRelatedKey) {
                    // each fields
                    foreach ($whereRelatedKey as $field) {
                        extract($field);
                        // checker value operator
                        $operator = strstr($val, '|') ? '|' : ',';
                        foreach (explode($operator, $val) as $id=>$val) {
                            $val = in_array($separator, ['ilike', 'not ilike']) ? "%$val%" : $val;
                            if ($id == 0 || $operator == ',') {
                                $q->where($key, $separator, $val);
                            } else {
                                $q->orWhere($key, $separator, $val);
                            }
                        }
                    }
                }]);
            }
        }

        if (count($where['where']) > 0) {
            // each field
            foreach ($where['where'] as $field) {
                $this->where(function ($q) use ($field) {
                    extract($field);
                    // checker value operator
                    $operator = strstr($val, '|') ? '|' : ',';
                    foreach (explode($operator, $val) as $id=>$val) {
                        $val = in_array($separator, ['ilike', 'not ilike']) ? "%$val%" : $val;
                        if ($id == 0 || $operator == ',') {
                            $q->where($key, $separator, $val);
                        } else {
                            $q->orWhere($key, $separator, $val);
                        }
                    }
                });
            }
        }

        return $collections;
    }

    public function table()
    {
        $limit 	= request('limit', 10);
        $sort 	= request('sort', 'id');
		$order	= request('order') == 'ascending'? 'asc': 'desc';

        return $this->filtering()
            ->orderBy($sort, $order)
            ->paginate($limit);
    }

	//public function delete()
    //{
        //return parent::delete();
    //}
}
