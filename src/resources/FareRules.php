<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightOffer
 * @see FlightOffer
 */
class FareRules implements ResourceInterface
{
    private ?string $currency = null;
    private ?array $rules = null;

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @return TermAndCondition[]|null
     */
    public function getRules(): ?array
    {
        return Resource::toResourceArray(
            $this->rules,
            TermAndCondition::class
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
