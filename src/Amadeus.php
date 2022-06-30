<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\BasicHTTPClient;
use Amadeus\Client\HTTPClient;

/**
 * <p>
 * The Amadeus API client. To initialize, use the builder as follows:
 * </p>
 *
 * <code>
 * $amadeus =
 *     Amadeus::builder("REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET")->build();
 * </code>
 */
class Amadeus
{
    /**
     * The SDK version.
     */
    public const VERSION = "0.1.1";

    private Configuration $configuration;

    private HTTPClient $client;

    /**
     * <p>
     * A namespaced client for the <code>/airport</code> endpoints.
     * </p>
     */
    private Airport $airport;

    /**
     * <p>
     * A namespaced client for the <code>/shopping</code> endpoints.
     * </p>
     */
    private Shopping $shopping;

    /**
     * <p>
     * A namespaced client for the <code>/reference-data</code> endpoints.
     * </p>
     */
    private ReferenceData $referenceData;

    /**
     * <p>
     * A namespaced client for the <code>/booking</code> endpoints.
     * </p>
     */
    private Booking $booking;

    /**
     * @param Configuration $configuration
     */
    public function __construct(
        Configuration $configuration
    ) {
        $this->configuration = $configuration;

        $this->client = $configuration->getHttpClient(); //Call Factory method

        $this->airport = new Airport($this);
        $this->shopping = new Shopping($this);
        $this->referenceData = new ReferenceData($this);
        $this->booking = new Booking($this);
    }

    /**
     * Creates an AmadeusBuilder object that can be used to build an Amadeus.
     *
     * <code>
     *  $amadeus = Amadeus::builder("CLIENT_ID", "CLIENT_SECRET")->build();
     * </code>
     *
     * @param string $clientId      Your API Client ID
     * @param string $clientSecret  Your API Client Secret
     * @return AmadeusBuilder
     */
    public static function builder(string $clientId, string $clientSecret): AmadeusBuilder
    {
        return new AmadeusBuilder(new Configuration($clientId, $clientSecret));
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * Get the HTTP Client
     * @return BasicHTTPClient|HTTPClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * <p>
     * Get a namespaced client for the <code>/airport</code> endpoints.
     * </p>
     * @return Airport
     */
    public function getAirport(): Airport
    {
        return $this->airport;
    }

    /**
     * <p>
     * Get a namespaced client for the <code>/shopping</code> endpoints.
     * </p>
     *
     * @return Shopping
     */
    public function getShopping(): Shopping
    {
        return $this->shopping;
    }

    /**
     * <p>
     * Get a namespaced client for the <code>/referenceData</code> endpoints.
     * </p>
     * @return ReferenceData
     */
    public function getReferenceData(): ReferenceData
    {
        return $this->referenceData;
    }

    /**
     * <p>
     * Get a namespaced client for the <code>/booking</code> endpoints.
     * </p>
     * @return Booking
     */
    public function getBooking(): Booking
    {
        return $this->booking;
    }
}
