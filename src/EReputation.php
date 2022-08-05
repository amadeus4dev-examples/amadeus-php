<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\EReputation\HotelSentiments;

/**
 * A namespaced client for the
 * "/e-reputation" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getEReputation();
 *
 */
class EReputation
{
    /**
     * A namespaced client for the
     * "/v2/e-reputation/hotel-sentiments" endpoints.
     */
    private HotelSentiments $hotelSentiments;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->hotelSentiments = new HotelSentiments($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v2/e-reputation/hotel-sentiments" endpoints.
     * @return HotelSentiments
     */
    public function getHotelSentiments(): HotelSentiments
    {
        return $this->hotelSentiments;
    }
}
