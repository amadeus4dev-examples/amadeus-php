<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A FlightAvailability object as returned by the Flight Availabilities Search API.
 * @see FlightAvailabilities
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-availabilities-search/api-reference
 */
class FlightAvailability extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $id = null;
    private ?string $originDestinationId = null;
    private ?string $source = null;
    private ?bool $instantTicketingRequired = null;
    private ?bool $paymentCardRequired = null;
    private ?string $duration = null;
    private ?array $segments = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getOriginDestinationId(): ?string
    {
        return $this->originDestinationId;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return bool|null
     */
    public function getInstantTicketingRequired(): ?bool
    {
        return $this->instantTicketingRequired;
    }

    /**
     * @return bool|null
     */
    public function getPaymentCardRequired(): ?bool
    {
        return $this->paymentCardRequired;
    }

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @return FlightExtendedSegment[]|null
     */
    public function getSegments(): ?array
    {
        return Resource::toResourceArray(
            $this->segments,
            FlightExtendedSegment::class
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
