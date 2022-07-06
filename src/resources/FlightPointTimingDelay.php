<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Timing
 * @see FlightPointTiming
 */
class FlightPointTimingDelay implements ResourceInterface
{
    private ?string $duration = null;

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
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
