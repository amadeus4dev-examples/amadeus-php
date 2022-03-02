<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class AircraftEquipment
{
    private string $code;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

}