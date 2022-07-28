<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightBookingRequirements.
 * @see FlightBookingRequirements::getTravelerRequirements()
 */
class PassengerConditions implements ResourceInterface
{
    private ?string $travelerId = null;
    private ?bool $genderRequired = null;
    private ?bool $documentRequired = null;
    private ?bool $documentIssuanceCityRequired = null;
    private ?bool $dateOfBirthRequired = null;
    private ?bool $redressRequiredIfAny = null;
    private ?bool $airFranceDiscountRequired = null;
    private ?bool $spanishResidentDiscountRequired = null;
    private ?bool $residenceRequired = null;

    /**
     * @return string|null
     */
    public function getTravelerId(): ?string
    {
        return $this->travelerId;
    }

    /**
     * @return bool|null
     */
    public function getGenderRequired(): ?bool
    {
        return $this->genderRequired;
    }

    /**
     * @return bool|null
     */
    public function getDocumentRequired(): ?bool
    {
        return $this->documentRequired;
    }

    /**
     * @return bool|null
     */
    public function getDocumentIssuanceCityRequired(): ?bool
    {
        return $this->documentIssuanceCityRequired;
    }

    /**
     * @return bool|null
     */
    public function getDateOfBirthRequired(): ?bool
    {
        return $this->dateOfBirthRequired;
    }

    /**
     * @return bool|null
     */
    public function getRedressRequiredIfAny(): ?bool
    {
        return $this->redressRequiredIfAny;
    }

    /**
     * @return bool|null
     */
    public function getAirFranceDiscountRequired(): ?bool
    {
        return $this->airFranceDiscountRequired;
    }

    /**
     * @return bool|null
     */
    public function getSpanishResidentDiscountRequired(): ?bool
    {
        return $this->spanishResidentDiscountRequired;
    }

    /**
     * @return bool|null
     */
    public function getResidenceRequired(): ?bool
    {
        return $this->residenceRequired;
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
