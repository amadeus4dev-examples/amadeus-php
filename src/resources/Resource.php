<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\Response;

class Resource
{
    private ?Response $response = null;

    /**
     * @param Response $response
     * @param string $class
     * @return object
     */
    public static function fromObject(Response $response, string $class): object
    {
        $data = $response->getData(); // $data is an object
        $resource = new $class();
        foreach ($data as $key => $value) {
            $resource->__set($key, $value);
        }
        $resource->response = $response;
        return $resource;
    }

    /**
     * @param Response $response
     * @param string $class
     * @return array
     */
    public static function fromArray(Response $response, string $class): array
    {
        $data = $response->getData(); // $data is an array
        $resources = array();
        foreach ($data as $object) {
            $resource = new $class();
            foreach ($object as $key => $value) {
                $resource->__set($key, $value);
            }
            $resource->response = $response; // plan A
            $resources[] = $resource;
        }
        //$resources['response'] = $response; //plan B
        return $resources;
    }

    /**
     * @param object $object
     * @param string $class
     * @return object
     */
    public static function toResourceObject(object $object, string $class): object
    {
        $resourceObject = new $class();
        foreach ($object as $key => $value) {
            $resourceObject->__set($key, $value);
        }
        return $resourceObject;
    }

    /**
     * @param array $array
     * @param string $class
     * @return array
     */
    public static function toResourceArray(array $array, string $class): array
    {
        $resourceArray = array();
        foreach ($array as $element) {
            $instance = new $class($element);
            foreach ($element as $key => $value) {
                $instance->__set($key, $value);
            }
            $resourceArray[] = $instance;
        }
        return $resourceArray;
    }

    /**
     * @return Response|null
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }
}
