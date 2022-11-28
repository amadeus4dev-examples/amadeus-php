<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in TravelerElement
 * @see TravelerElement::getName()
 */
class TravelerName implements ResourceInterface
{
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $middleName = null;
    private ?string $secondLastName = null;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @return string|null
     */
    public function getSecondLastName(): ?string
    {
        return $this->secondLastName;
    }

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'secondMiddleName' => $this->secondLastName,
            'lastName' => $this->firstName
        ];
    }

    public function toObject(): TravelerElement
    {
        $resourceObject = new TravelerElement();
        $resourceObject->__set('firstName', $this->getFirstName());
        $resourceObject->__set('middleName', $this->getMiddleName());
        $resourceObject->__set('secondLastName', $this->getSecondLastName());
        $resourceObject->__set('lastName', $this->getLastName());
        return $resourceObject;
    }

    public function __toString(): string
    {
        return Resource::toString(get_object_vars($this));
    }
}
