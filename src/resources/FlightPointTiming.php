<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Arrival, Departure
 * @see FlightPointArrival::getTimings()
 * @see FlightPointDeparture::getTimings()
 */
class FlightPointTiming implements ResourceInterface
{
    private ?string $qualifier = null;
    private ?string $value = null;
    private ?array $delays = null;

    /**
     * @return string|null
     */
    public function getQualifier(): ?string
    {
        return $this->qualifier;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return FlightPointTimingDelay[]|null
     */
    public function getDelays(): ?array
    {
        return Resource::toResourceArray(
            $this->delays,
            FlightPointTimingDelay::class
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
