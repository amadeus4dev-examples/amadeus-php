<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\EReputation\HotelSentiments;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/e-reputation</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getEReputation();
 * </code>
 */
class EReputation
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v2/e-reputation/hotel-sentiments</code> endpoints.
     * </p>
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
     * <p>
     *   Get a namespaced client for the
     *   <code>/v2/e-reputation/hotel-sentiments</code> endpoints.
     * </p>
     * @return HotelSentiments
     */
    public function getHotelSentiments(): HotelSentiments
    {
        return $this->hotelSentiments;
    }
}
