<?php

namespace Amadeus\Resources;

use JsonMapper;
use JsonMapper_Exception;

class Resource
{
    /**
     * @param object $response
     * @param object $object
     * @return object
     * @throws JsonMapper_Exception
     */
    public static function fromArray(object $response, object $object): object
    {
        $data = $response->{'data'};
        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;
        return $mapper->map($data, $object);
    }

    /**
     * @param object $response
     * @param string $class
     * @return iterable
     * @throws JsonMapper_Exception
     */
    public static function fromObject(object $response, string $class): iterable
    {
        $data = $response->{'data'};
        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;
        return $mapper->mapArray($data, array(), $class);
    }

}