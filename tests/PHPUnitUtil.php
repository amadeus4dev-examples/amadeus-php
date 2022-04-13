<?php declare(strict_types=1);

namespace Amadeus\Tests;

use ReflectionException;

class PHPUnitUtil
{
    /**
     * @throws ReflectionException
     */
    public static function callMethod($obj, string $methodName, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
