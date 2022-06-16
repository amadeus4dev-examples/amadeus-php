<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\ReferenceData\Locations\Hotels\ByCity;
use Amadeus\ReferenceData\Locations\Hotels\ByGeocode;
use Amadeus\ReferenceData\Locations\Hotels\ByHotels;

class Hotels
{
    private ByCity $byCity;

    private ByGeocode $byGeocode;

    private ByHotels $byHotels;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->byCity = new ByCity($amadeus);
        $this->byGeocode = new ByGeocode($amadeus);
        $this->byHotels = new ByHotels($amadeus);
    }

    /**
     * @return ByCity
     */
    public function getByCity(): ByCity
    {
        return $this->byCity;
    }

    /**
     * @return ByGeocode
     */
    public function getByGeocode(): ByGeocode
    {
        return $this->byGeocode;
    }

    /**
     * @return ByHotels
     */
    public function getByHotels(): ByHotels
    {
        return $this->byHotels;
    }
}
