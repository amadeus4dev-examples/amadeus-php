<?php

declare(strict_types=1);

namespace Amadeus\Utils;

use Amadeus\Resources\Resource;
use Amadeus\Response;

abstract class PaginationAbstract
{
    protected string $className;

    /**
     * @param Response|null $response
     * @return array|null
     */
    protected function pageResult(?Response $response): ?array
    {
        if ($response != null) {
            return Resource::fromArray($response, $this->className);
        } else {
            return null;
        }
    }

    abstract public function previous($resource): ?array;
    abstract public function next($resource): ?array;
    abstract public function first($resource): ?array;
    abstract public function last($resource): ?array;
}
