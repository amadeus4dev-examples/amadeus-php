<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Shopping\Availability;
use Amadeus\Shopping\FlightOffers;
use Amadeus\Shopping\HotelOffer;
use Amadeus\Shopping\HotelOffers;

class Shopping
{
    private ?Availability $availability;
    private ?FlightOffers $flightOffers;
    private ?HotelOffer $hotelOffer;
    private ?HotelOffers $hotelOffers;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->availability = new Availability($amadeus);
        $this->flightOffers = new FlightOffers($amadeus);
        $this->hotelOffer = new HotelOffer($amadeus);
        $this->hotelOffers = new HotelOffers($amadeus);
    }

    /**
     * @return Availability|null
     */
    public function getAvailability(): ?Availability
    {
        return $this->availability;
    }

    /**
     * @return FlightOffers|null
     */
    public function getFlightOffers(): ?FlightOffers
    {
        return $this->flightOffers;
    }

    /**
     * @return HotelOffer|null
     */
    public function getHotelOffer(): ?HotelOffer
    {
        return $this->hotelOffer;
    }

    /**
     * @return HotelOffers|null
     */
    public function getHotelOffers(): ?HotelOffers
    {
        return $this->hotelOffers;
    }
}
