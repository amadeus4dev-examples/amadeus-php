<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Analytics implements ResourceInterface
{
    private ?object $travelers = null;

    /**
     * @return object|null
     */
    public function getTravelers(): ?object
    {
        return $this->travelers;
    }

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    /**
     * @return string|null
     */
    public function __toString(): ?string
    {
        return Resource::toString(get_object_vars($this));
    }
}
