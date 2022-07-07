<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\Travel\Predictions\FlightDelay;

/**
 * A DelayPrediction object as returned by the Airport Routes API.
 * @see FlightDelay
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-delay-prediction/api-reference
 */
class DelayPrediction extends Resource implements ResourceInterface
{
    private ?string $id = null;
    private ?string $probability = null;
    private ?string $result = null;
    private ?string $subType = null;
    private ?string $type = null;

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
    public function getProbability(): ?string
    {
        return $this->probability;
    }

    /**
     * @return string|null
     */
    public function getResult(): ?string
    {
        return $this->result;
    }

    /**
     * @return string|null
     */
    public function getSubType(): ?string
    {
        return $this->subType;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
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