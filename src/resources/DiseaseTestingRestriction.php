<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction
 */
class DiseaseTestingRestriction implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $isRequired = null;
    private ?string $when = null;
    private ?string $requirement = null;
    private ?string $rules = null;
    private ?string $testType = null;
    private ?int $minimumAge = null;
    private ?object $ValidityPeriod = null;

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getIsRequired(): ?string
    {
        return $this->isRequired;
    }

    /**
     * @return string|null
     */
    public function getWhen(): ?string
    {
        return $this->when;
    }

    /**
     * @return string|null
     */
    public function getRequirement(): ?string
    {
        return $this->requirement;
    }

    /**
     * @return string|null
     */
    public function getRules(): ?string
    {
        return $this->rules;
    }

    /**
     * @return string|null
     */
    public function getTestType(): ?string
    {
        return $this->testType;
    }

    /**
     * @return int|null
     */
    public function getMinimumAge(): ?int
    {
        return $this->minimumAge;
    }

    /**
     * @return ValidityPeriod|null
     */
    public function getValidityPeriod(): ?object
    {
        return Resource::toResourceObject(
            $this->ValidityPeriod,
            ValidityPeriod::class
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
