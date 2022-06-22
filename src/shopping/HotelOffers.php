<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v3/shopping/hotelOffers</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping()->getHotelOffers();
 * </code>
 */
class HotelOffers
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
     *   Search for hotels and retrieve availability and rates information.
     * </p>
     *
     * <code>
     *  $amadeus->getShopping()->getHotelOffers()->get(
     *      array(
     *              "hotelId" => "MCLONGHM",
     *              "adults" => 1,
     *              "checkInDate" => "2022-12-29",
     *              "roomQuantity" => 1,
     *              "paymentPolicy" => "NONE",
     *              "bestRateOnly" => true
     *      )
     * );
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference
     *
     * @param array $params                         the parameters to send to the API
     * @return \Amadeus\Resources\HotelOffers[]     an API resource
     * @throws ResponseException                    when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v3/shopping/hotel-offers",
            $params
        );

        return Resource::fromArray($response, \Amadeus\Resources\HotelOffers::class);
    }
}
