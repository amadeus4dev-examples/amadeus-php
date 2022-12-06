<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Shopping\Activities;
use Amadeus\Shopping\Activity;
use Amadeus\Shopping\Availability;
use Amadeus\Shopping\FlightDates;
use Amadeus\Shopping\FlightDestinations;
use Amadeus\Shopping\FlightOffers;
use Amadeus\Shopping\HotelOffer;
use Amadeus\Shopping\HotelOffers;
use Amadeus\Shopping\SeatMaps;

/**
 * A namespaced client for the
 * "/shopping" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping();
 *
 */
class Shopping
{
    private Amadeus $amadeus;

    /**
     * A namespaced client for the
     * "/v1/shopping/availability" endpoints.
     */
    private Availability $availability;

    /**
     * A namespaced client for the
     * "/v2/shopping/flight-offers" endpoints.
     */
    private FlightOffers $flightOffers;

    /**
     * A namespaced client for the
     * "/v1/shopping/seatmaps" endpoints.
     */
    private SeatMaps $seatMaps;

    /**
     * A namespaced client for the
     * "/v3/shopping/hotel-offers" endpoints.
     */
    private HotelOffers $hotelOffers;

    /**
     * A namespaced client for the
     * "/v1/shopping/flight-dates" endpoints.
     */
    private FlightDates $flightDates;

    /**
     * A namespaced client for the
     * "/v1/shopping/flight-destinations" endpoints.
     */
    private FlightDestinations $flightDestinations;

    /**
     * A namespaced client for the
     * "/v1/shopping/activities" endpoints.
     */
    private Activities $activities;


    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->availability = new Availability($amadeus);
        $this->flightOffers = new FlightOffers($amadeus);
        $this->seatMaps = new SeatMaps($amadeus);
        $this->hotelOffers = new HotelOffers($amadeus);
        $this->flightDates = new FlightDates($amadeus);
        $this->flightDestinations = new FlightDestinations($amadeus);
        $this->activities = new Activities($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/shopping/availability" endpoints.
     * @return Availability
     */
    public function getAvailability(): Availability
    {
        return $this->availability;
    }

    /**
     * Get a namespaced client for the
     * "/v1/shopping/seatmaps" endpoints.
     * @return SeatMaps
     */
    public function getSeatMaps(): SeatMaps
    {
        return $this->seatMaps;
    }

    /**
     * Get a namespaced client for the
     * "/v2/shopping/flight-offers" endpoints.
     * @return FlightOffers
     */
    public function getFlightOffers(): FlightOffers
    {
        return $this->flightOffers;
    }

    /**
     * Get a namespaced client for the
     * "/v3/shopping/hotel-offers/:offer_id" endpoints.
     * @param string $offerId
     * @return HotelOffer
     */
    public function getHotelOffer(string $offerId): HotelOffer
    {
        return new HotelOffer($this->amadeus, $offerId);
    }

    /**
     * Get a namespaced client for the
     * "/v3/shopping/hotel-offers" endpoints.
     * @return HotelOffers
     */
    public function getHotelOffers(): HotelOffers
    {
        return $this->hotelOffers;
    }

    /**
     * Get a namespaced client for the
     * "/v1/shopping/flight-dates" endpoints.
     * @return FlightDates
     */
    public function getFlightDates(): FlightDates
    {
        return $this->flightDates;
    }

    /**
     * Get a namespaced client for the
     * "/v1/shopping/flight-destinations" endpoints.
     * @return FlightDestinations
     */
    public function getFlightDestinations(): FlightDestinations
    {
        return $this->flightDestinations;
    }

    /**
     * Get a namespaced client for the
     * "/v1/shopping/activities" endpoints.
     * @return Activities
     */
    public function getActivities(): Activities
    {
        return $this->activities;
    }

    /**
     * Get a namespaced client for the
     * "/v1/shopping/activities/:activity_id" endpoints.
     * @param string $activityId
     * @return Activity
     */
    public function getActivity(string $activityId): Activity
    {
        return new Activity($this->amadeus, $activityId);
    }
}
