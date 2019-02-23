<?php

namespace App\JsonApi\SensorDatas;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Adapter extends AbstractAdapter
{

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\SensorData(), $paging);
    }

    /**
     * @param Builder $query
     * @param Collection $filters
     * @return void
     */
    protected function filter($query, Collection $filters)
    {
        
        if ($key = $filters->get('sensor_id')) {
            $query->where('sensor_datas.sensor_id', '=', $key);
        }
        if ($key = $filters->get('key')) {
            $query->where('sensor_datas.key', '=', $key);
        }
        if ($val = $filters->get('value')) {
            $query->where('sensor_datas.value', '=', $val);
        }
    }

}
