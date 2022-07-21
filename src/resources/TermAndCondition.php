<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FareRules
 * @see FareRules
 */
class TermAndCondition implements ResourceInterface
{
    private ?string $category = null;
    private ?string $circumstances = null;
    private ?bool $notApplicable = null;
    private ?string $maxPenaltyAmount = null;
    private ?array $descriptions = null;

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getCircumstances(): ?string
    {
        return $this->circumstances;
    }

    /**
     * @return bool|null
     */
    public function getNotApplicable(): ?bool
    {
        return $this->notApplicable;
    }

    /**
     * @return string|null
     */
    public function getMaxPenaltyAmount(): ?string
    {
        return $this->maxPenaltyAmount;
    }

    /**
     * @return Description[]|null
     */
    public function getDescriptions(): ?array
    {
        return Resource::toResourceArray(
            $this->descriptions,
            Description::class
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
