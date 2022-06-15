<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Analytics implements ResourceInterface
{
    private ?object $travelers = null;

    /**
     * @return Travelers|null
     */
    public function getTravelers(): ?object
    {
        return Resource::toResourceObject(
            $this->travelers,
            Travelers::class
        );
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
