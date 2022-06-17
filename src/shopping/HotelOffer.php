<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;

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
        $response = $this->amadeus->getClient()->get(
            "/v3/shopping/hotel-offers",
            $offerId
        );

        return Resource::fromObject($response, \Amadeus\Resources\HotelOffers::class);
    }
}
