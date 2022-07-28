<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DiseaseTestingRestriction
 * @see DiseaseTestingRestriction::getValidityPeriod()
 */
class ValidityPeriod implements ResourceInterface
{
    private ?string $delay = null;
    private ?string $referenceDateType = null;

    /**
     * @return string|null
     */
    public function getDelay(): ?string
    {
        return $this->delay;
    }

    /**
     * @return string|null
     */
    public function getReferenceDateType(): ?string
    {
        return $this->referenceDateType;
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
