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

    public const RESOURCE_PATH_ROOT = __DIR__ . "/resources/__files/";
}
