<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Activity
 * @see Activity::getPrice()
 */
class ElementaryPrice implements ResourceInterface
{
    private ?string $amount = null;
    private ?string $currency = null;

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
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
