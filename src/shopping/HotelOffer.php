<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v3/shopping/hotel-offers/:offer_id</code> endpoints.
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
    private string $offerId;

    /**
     * @param Amadeus $amadeus
     * @param string $offerId
     */
    public function __construct(Amadeus $amadeus, string $offerId)
    {
        $this->amadeus = $amadeus;
        $this->offerId = $offerId;
    }

    /**
     * ###Hotel Search API
     * <p>
     *   Returns details for a specific offer.
     * </p>
     *
     * <code>
     *  $amadeus->getShopping()->getHotelOffer("XXX")->get();
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference
     *
     * @return \Amadeus\Resources\HotelOffers   an API resource
     * @throws ResponseException when an exception occurs
     */
    public function get(): object
    {
        $response = $this->amadeus->getClient()->getWithOnlyPath(
            "/v3/shopping/hotel-offers"."/".$this->offerId
        );

        return Resource::fromObject($response, \Amadeus\Resources\HotelOffers::class);
    }
}
