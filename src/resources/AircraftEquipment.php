<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class AircraftEquipment
{
    private ?string $code = null;

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
    public function getCode(): ?string
    {
        return $this->code;
    }

}