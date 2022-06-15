<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use ReflectionClass;
use ReflectionException;

class PHPUnitUtil
{
    /**
     * @param $obj
     * @param string $methodName
     * @param array $args
     * @return mixed
     * @throws ReflectionException
     */
    public static function callMethod($obj, string $methodName, array $args)
    {
        $class = new ReflectionClass($obj);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }

    /**
     * @param string $fileName
     * @return false|string
     */
    public static function readFile(string $fileName)
    {
        $file = fopen($fileName, "r");
        $fileSize = filesize($fileName);
        $fileContent = fread($file, $fileSize);
        fclose($file);
        return $fileContent;
    }

    /**
     * @param $object
     * @return string
     */
    public static function toString($object): string
    {
        return json_encode(
            $object,
            JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES
        );
    }

    public const RESOURCE_PATH_ROOT = __DIR__ . "/resources/__files/";
}
