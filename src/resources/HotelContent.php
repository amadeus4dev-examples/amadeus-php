<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelContent implements ResourceInterface
{
    private ?string $hotelId = null;
    private ?string $chainCode = null;
    private ?string $brandCode = null;
    private ?string $dupeId = null;
    private ?string $name = null;
    private ?string $cityCode = null;

    /**
     * @return string|null
     */
    public function getHotelId(): ?string
    {
        return $this->hotelId;
    }

    /**
     * @return string|null
     */
    public function getChainCode(): ?string
    {
        return $this->chainCode;
    }

    /**
     * @return string|null
     */
    public function getBrandCode(): ?string
    {
        return $this->brandCode;
    }

    /**
     * @return string|null
     */
    public function getDupeId(): ?string
    {
        return $this->dupeId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getCityCode(): ?string
    {
        return $this->cityCode;
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
