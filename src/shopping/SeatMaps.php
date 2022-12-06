<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;
use Amadeus\Resources\SeatMap;

/**
 * A namespaced client for the
 * "/v1/shopping/seatmaps" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping()->getSeatMaps();
 *
 */
class SeatMaps
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
     * Returns all the seat maps of a given order.
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/seatmap-display/api-reference
     *
     * @param array|null $params   Required URL parameters such with either:
     *                              flightOrderId : Identifier of the order
     *                              flight-orderId : (Deprecated) Identifier of the order.
     * @return array               Returns an array of SeatMap classes.
     * @throws ResponseException   When an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/shopping/seatmaps',
            $params
        );
        return Resource::fromArray($response, SeatMap::class);
    }

    /**
     * Returns all the seat maps of a given flightOffer.
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/seatmap-display/api-reference
     *
     * @param string $body          Required POST parameters are an array data property with a JSON flightOffer.
     * @param array|null $params
     * @return array                Returns an array of SeatMap classes.
     * @throws ResponseException    When an exception occurs
     */
    public function post(string $body, ?array $params = null): array
    {
        $response = $this->amadeus->getClient()->postWithStringBody(
            '/v1/shopping/seatmaps',
            $body,
            $params
        );

        return Resource::fromArray($response, SeatMap::class);
    }
}