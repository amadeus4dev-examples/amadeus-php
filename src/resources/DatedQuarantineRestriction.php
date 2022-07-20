<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction
 */
class DatedQuarantineRestriction implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $eligiblePerson = null;
    private ?string $quarantineType = null;
    private ?int $duration = null;
    private ?string $rules = null;
    private ?string $mandateList = null;
    private ?array $quarantineOnArrivalAreas = null;

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
    public function getEligiblePerson(): ?string
    {
        return $this->eligiblePerson;
    }

    /**
     * @return string|null
     */
    public function getQuarantineType(): ?string
    {
        return $this->quarantineType;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
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
    public function getMandateList(): ?string
    {
        return $this->mandateList;
    }

    /**
     * @return Area[]|null
     */
    public function getQuarantineOnArrivalAreas(): ?array
    {
        return Resource::toResourceArray(
            $this->quarantineOnArrivalAreas,
            Area::class
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
