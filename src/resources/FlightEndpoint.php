<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightEndpoint
{
    private ?string $iataCode = null;
    private ?string $terminal = null;
    private ?string $at = null;

    /**
     * @return string|null
     */
    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    /**
     * @return string|null
     */
    public function getTerminal(): ?string
    {
        return $this->terminal;
    }

    /**
     * @return string|null
     */
    public function getAt(): ?string
    {
        return $this->at;
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this))."\n";
    }

}
