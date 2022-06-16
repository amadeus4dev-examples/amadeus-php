<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class TravelerElement implements ResourceInterface
{
    private ?string $id = null;
    private ?string $date = null;
    private ?string $gender = null;
    private ?object $name = null;
    private ?array $documents = null;
    private ?object $contact = null;

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
    public function getDate(): ?string
    {
        return $this->date;
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
