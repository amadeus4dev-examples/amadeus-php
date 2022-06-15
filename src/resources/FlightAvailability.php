<?php

declare(strict_types=1);

namespace Amadeus\Resources;

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
     * @return ExtendedSegment[]|null
     */
    public function getSegments(): ?array
    {
        return Resource::toResourceArray(
            $this->segments,
            ExtendedSegment::class
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
