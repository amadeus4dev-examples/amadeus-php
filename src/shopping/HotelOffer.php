<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;

/**
 * Hotel Search API
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference
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
     * @param string $offerId
     * @return \Amadeus\Resources\HotelOffers
     * @throws ResponseException
     */
    public function get(string $offerId): object
    {
        $response = $this->amadeus->getClient()->getWithOnlyPath(
            "/v3/shopping/hotel-offers"."/".$offerId
        );

        return Resource::fromObject($response, \Amadeus\Resources\HotelOffers::class);
    }
}
