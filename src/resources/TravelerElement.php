<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightOrder
 * @see FlightOrder::getTravelers()
 */
class TravelerElement implements ResourceInterface
{
    private ?string $id = null;
    private ?string $gender = null;
    private ?object $name = null;
    private ?array $documents = null;
    private ?object $contact = null;
    private ?string $dateOfBirth = null;

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
    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return TravelerName|null
     */
    public function getName(): ?object
    {
        // Note: Temporary work around, as get_object_vars returns empty on private properties
        if (8 <= (int) phpversion('tidy')) {
           return $this->name->toArray();
        }


        return Resource::toResourceObject(
            $this->name,
            TravelerName::class
        );
    }

    /**
     * @return TravelerDocuments[]|null
     */
    public function getDocuments(): ?array
    {
        return Resource::toResourceArray(
            $this->documents,
            TravelerDocuments::class
        );
    }

    /**
     * @return TravelerContact|null
     */
    public function getContact(): ?object
    {
        return Resource::toResourceObject(
            $this->contact,
            TravelerContact::class
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
