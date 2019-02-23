<?php

namespace App\JsonApi\Sensors;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'sensors';

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
            
            'name' => $resource->name,
            'description' => $resource->description,
            'location' => $resource->location,
            'created-at' => $resource->created_at->toAtomString(),
            
        ];
    }
}
