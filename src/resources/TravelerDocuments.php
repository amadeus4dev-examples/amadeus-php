<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class TravelerDocuments implements ResourceInterface
{
    private ?string $number = null;
    private ?string $issuanceDate = null;
    private ?string $expiryDate = null;
    private ?string $issuanceCountry = null;
    private ?string $issuanceLocation = null;
    private ?string $nationality = null;
    private ?string $birthPlace = null;
    private ?string $documentType = null;
    private ?string $validityCountry = null;
    private ?string $birthCountry = null;
    private ?bool $holder = null;

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return string|null
     */
    public function getIssuanceDate(): ?string
    {
        return $this->issuanceDate;
    }

    /**
     * @return string|null
     */
    public function getExpiryDate(): ?string
    {
        return $this->expiryDate;
    }

    /**
     * @return string|null
     */
    public function getIssuanceCountry(): ?string
    {
        return $this->issuanceCountry;
    }

    /**
     * @return string|null
     */
    public function getIssuanceLocation(): ?string
    {
        return $this->issuanceLocation;
    }

    /**
     * @return string|null
     */
    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    /**
     * @return string|null
     */
    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    /**
     * @return string|null
     */
    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    /**
     * @return string|null
     */
    public function getValidityCountry(): ?string
    {
        return $this->validityCountry;
    }

    /**
     * @return string|null
     */
    public function getBirthCountry(): ?string
    {
        return $this->birthCountry;
    }

    /**
     * @return bool|null
     */
    public function getHolder(): ?bool
    {
        return $this->holder;
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
