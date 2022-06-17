<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductCancellationPolicy implements ResourceInterface
{
    private ?string $type = null;
    private ?string $amount = null;
    private ?int $numberOfNights = null;
    private ?string $percentage = null;
    private ?string $deadline = null;
    private ?object $description = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @return int|null
     */
    public function getNumberOfNights(): ?int
    {
        return $this->numberOfNights;
    }

    /**
     * @return string|null
     */
    public function getPercentage(): ?string
    {
        return $this->percentage;
    }

    /**
     * @return string|null
     */
    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    /**
     * @return QualifiedFreeText|null
     */
    public function getDescription(): ?object
    {
        return Resource::toResourceObject(
            $this->description,
            QualifiedFreeText::class
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
