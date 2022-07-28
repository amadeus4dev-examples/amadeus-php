<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightPoint.
 * @see FlightPoint::getArrival()
 */
class FlightPointArrival implements ResourceInterface
{
    private ?object $terminal = null;
    private ?object $gate = null;
    private ?array $timings = null;

    /**
     * @return object|null
     */
    public function getTerminal(): ?object
    {
        return Resource::toResourceObject(
            $this->terminal,
            FlightPointTerminal::class
        );
    }

    /**
     * @return FlightPointGate|null
     */
    public function getGate(): ?object
    {
        return Resource::toResourceObject(
            $this->gate,
            FlightPointGate::class
        );
    }

    /**
     * @return FlightPointTiming[]|null
     */
    public function getTimings(): ?array
    {
        return Resource::toResourceArray(
            $this->timings,
            FlightPointTiming::class
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
