<?php

namespace Amadeus\Resources;

use Amadeus\Response;
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
    public static function fromObject(object $response, object $object): object
    {
        $data = $response->{'data'}; // $data is an object
        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;
        return $mapper->map($data, $object);
    }

    /**
     * @param Response $response
     * @param string $class
     * @return iterable
     * @throws JsonMapper_Exception
     */
    public static function fromArray(Response $response, string $class): iterable
    {
        $data = $response->getResult()->{'data'}; // $data is an array
        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;
        return $mapper->mapArray($data, array(), $class);
    }
}