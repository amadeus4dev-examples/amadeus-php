<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v3/shopping/hotelOffers/:offer_id</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping()->getHotelOffer();
 * </code>
 */
class HotelOffer
{
    private Amadeus $amadeus;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * ###Hotel Search API
     * <p>
     *   Returns details for a specific offer.
     * </p>
     *
     * <code>
     *  $amadeus->getShopping()->getHotelOffer()->get("XXX");
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference
     *
     * @param string $offerId                   the parameters to send to the API
     * @return \Amadeus\Resources\HotelOffers   an API resource
     * @throws ResponseException                when an exception occurs
     */
    public function get(string $offerId): object
    {
        $response = $this->amadeus->getClient()->getWithOnlyPath(
            "/v3/shopping/hotel-offers"."/".$offerId
        );

        return Resource::fromObject($response, \Amadeus\Resources\HotelOffers::class);
    }
}
