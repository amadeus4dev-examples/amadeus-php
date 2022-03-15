<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class Destination
{
    private ?string $type = null;
    private ?string $subtype = null;
    private ?string $name = null;
    private ?string $iataCode = null;

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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getSubtype(): ?string
    {
        return $this->subtype;
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
    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

}