<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightAvailability extends Resource
{
    private ?string $type = null;
    private ?string $id = null;
    private ?string $originDestinationId = null;
    private ?string $source = null;
    private ?bool $instantTicketRequired = null;
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
    public function getInstantTicketRequired(): ?bool
    {
        return $this->instantTicketRequired;
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
    public function getSegments(): ?iterable
    {
        return Resource::toResourceArray(
            $this->segments, ExtendedSegment::class);
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}
