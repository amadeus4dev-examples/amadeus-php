<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Location.
 * @see \Amadeus\Resources\Location::getAnalytics()
 */
class LocationAnalytics implements ResourceInterface
{
    private ?object $travelers = null;

    /**
     * @return LocationAnalyticsTravelers|null
     */
    public function getTravelers(): ?object
    {
        return Resource::toResourceObject(
            $this->travelers,
            LocationAnalyticsTravelers::class
        );
    }

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    public function __toString(): string
    {
        return Resource::toString(get_object_vars($this));
    }
}
