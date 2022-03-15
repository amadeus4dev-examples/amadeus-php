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
     * @param object $object
     */
    public function __construct(object $object)
    {
        foreach($object as $key =>  $value)
        {
            $this->$key = $value;
        }
    }

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

}
