<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction::getTransportation()
 */
class Transportation implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $transportationType = null;
    private ?string $isBanned = null;
    private ?string $throughDate = null;

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
    public function getTransportationType(): ?string
    {
        return $this->transportationType;
    }

    /**
     * @return string|null
     */
    public function getIsBanned(): ?string
    {
        return $this->isBanned;
    }

    /**
     * @return string|null
     */
    public function getThroughDate(): ?string
    {
        return $this->throughDate;
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
