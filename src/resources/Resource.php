<?php

namespace Amadeus\Resources;

use Amadeus\Response;

class Resource
{
    /**
     * @param object $response
     * @param string $class
     * @return object
     */
    public static function fromObject(object $response, string $class): object
    {
        $data = $response->getResult()->{'data'}; // $data is an object
        return new $class($data);
    }

    /**
     * @param Response $response
     * @param string $class
     * @return iterable
     */
    public static function fromArray(Response $response, string $class): iterable
    {
        $data = $response->getResult()->{'data'}; // $data is an array
        $resultArray = array();
        foreach ($data as $value)
        {
            $instance = new $class($value);
            $resultArray[] = $instance;
        }
        return $resultArray;
    }

    /**
     * @param object $object
     * @param string $class
     * @return object
     */
    public static function toResourceObject(object $object, string $class): object
    {
        return new $class($object);
    }

    /**
     * @param array $array
     * @param string $class
     * @return iterable
     */
    public static function toResourceArray(array $array, string $class): iterable
    {
        $resourceArray = array();
        foreach($array as $value)
        {
            $instance = new $class($value);
            $resourceArray[] = $instance;
        }
        return $resourceArray;
    }

}