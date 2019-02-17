<?php

namespace App\JsonApi\DashboardItems;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'dashboardItems';

    /**
     * @param $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'dashboard_id' => $resource->dashboard_id,
            'sensor_id' => $resource->sensor_id,
            'chart_key' => $resource->chart_key,

            'sensor_data_key' => json_decode($resource->sensor_data_key),
            'sensor_data_val' => $resource->sensor_data_val,
            'created_at' => $resource->created_at->toAtomString(),
            'updated_at' => $resource->updated_at->toAtomString(),
        ];
    }
}
