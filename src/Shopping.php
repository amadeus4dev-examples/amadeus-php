<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Shopping\Availability;
use Amadeus\Shopping\FlightDates;
use Amadeus\Shopping\FlightOffers;
use Amadeus\Shopping\HotelOffer;
use Amadeus\Shopping\HotelOffers;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/shopping</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping();
 * </code>
 */
class Shopping
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/shopping/availability</code> endpoints.
     * </p>
     */
    private ?Availability $availability;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v2/shopping/flight-offers</code> endpoints.
     * </p>
     */
    private ?FlightOffers $flightOffers;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v3/shopping/hotel-offers/:offer_id</code> endpoints.
     * </p>
     */
    private ?HotelOffer $hotelOffer;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v3/shopping/hotel-offers</code> endpoints.
     * </p>
     */
    private ?HotelOffers $hotelOffers;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/shopping/flight-dates</code> endpoints.
     * </p>
     */
    private ?FlightDates $flightDates;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->availability = new Availability($amadeus);
        $this->flightOffers = new FlightOffers($amadeus);
        $this->hotelOffer = new HotelOffer($amadeus);
        $this->hotelOffers = new HotelOffers($amadeus);
        $this->flightDates = new FlightDates($amadeus);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/shopping/availability</code> endpoints.
     * </p>
     * @return Availability|null
     */
    public function getAvailability(): ?Availability
    {
        return $this->availability;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v2/shopping/flight-offers</code> endpoints.
     * </p>
     * @return FlightOffers|null
     */
    public function getFlightOffers(): ?FlightOffers
    {
        return $this->flightOffers;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v3/shopping/hotel-offers/:offer_id</code> endpoints.
     * </p>
     * @return HotelOffer|null
     */
    public function getHotelOffer(): ?HotelOffer
    {
        return $this->hotelOffer;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v3/shopping/hotel-offers</code> endpoints.
     * </p>
     * @return HotelOffers|null
     */
    public function getHotelOffers(): ?HotelOffers
    {
        return $this->hotelOffers;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/shopping/flight-dates</code> endpoints.
     * </p>
     * @return FlightDates|null
     */
    public function getFlightDates(): ?FlightDates
    {
        return $this->flightDates;
    }
}
