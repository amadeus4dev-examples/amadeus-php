<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\BasicHTTPClient;
use Amadeus\Client\HTTPClient;

/**
 * The Amadeus API client. To initialize, use the builder as follows:
 *
 *      $amadeus =
 *          Amadeus::builder("REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET")->build();
 *
 */
class Amadeus
{
    /**
     * The SDK version.
     */
    public const VERSION = "0.3.0";

    private Configuration $configuration;

    private HTTPClient $client;

    /**
     * A namespaced client for the "/airport" endpoints.
     */
    private Airport $airport;

    /**
     * A namespaced client for the "/shopping" endpoints.
     */
    private Shopping $shopping;

    /**
     * A namespaced client for the "/reference-data" endpoints.
     */
    private ReferenceData $referenceData;

    /**
     * A namespaced client for the "/booking" endpoints.
     */
    private Booking $booking;

    /**
     * A namespaced client for the "/schedule" endpoints.
     */
    private Schedule $schedule;

    /**
     * A namespaced client for the "/travel" endpoints.
     */
    private Travel $travel;

    /**
     * A namespaced client for the "/duty-of-care" endpoints.
     */
    private DutyOfCare $dutyOfCare;

    /**
     * A namespaced client for the "/e-reputation" endpoints.
     */
    private EReputation $eReputation;

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
        $this->schedule = new Schedule($this);
        $this->travel = new Travel($this);
        $this->dutyOfCare = new DutyOfCare($this);
        $this->eReputation = new EReputation($this);
    }

    /**
     * Creates an AmadeusBuilder object that can be used to build an Amadeus.
     *
     *      $amadeus = Amadeus::builder("CLIENT_ID", "CLIENT_SECRET")->build();
     *
     * @param null|string $clientId      Your API Client ID
     * @param null|string $clientSecret  Your API Client Secret
     * @return AmadeusBuilder
     */
    public static function builder(?string $clientId = null, ?string $clientSecret = null): AmadeusBuilder
    {
        (($clientId == null) && ($clientSecret == null))
            ? $configuration = new Configuration(getenv('AMADEUS_CLIENT_ID'), getenv('AMADEUS_CLIENT_SECRET'))
            : $configuration = new Configuration($clientId, $clientSecret);

        return new AmadeusBuilder($configuration);
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
     * Get a namespaced client for the "airport" endpoints.
     * @return Airport
     */
    public function getAirport(): Airport
    {
        return $this->airport;
    }

    /**
     * Get a namespaced client for the "/shopping" endpoints.
     * @return Shopping
     */
    public function getShopping(): Shopping
    {
        return $this->shopping;
    }

    /**
     * Get a namespaced client for the "/referenceData" endpoints.
     * @return ReferenceData
     */
    public function getReferenceData(): ReferenceData
    {
        return $this->referenceData;
    }

    /**
     * Get a namespaced client for the "/booking" endpoints.
     * @return Booking
     */
    public function getBooking(): Booking
    {
        return $this->booking;
    }

    /**
     * Get a namespaced client for the "/schedule" endpoints.
     * @return Schedule
     */
    public function getSchedule(): Schedule
    {
        return $this->schedule;
    }

    /**
     * Get a namespaced client for the "/travel" endpoints.
     * @return Travel
     */
    public function getTravel(): Travel
    {
        return $this->travel;
    }

    /**
     * Get a namespaced client for the "/dutyOfCare" endpoints.
     * @return DutyOfCare
     */
    public function getDutyOfCare(): DutyOfCare
    {
        return $this->dutyOfCare;
    }

    /**
     * Get a namespaced client for the "/e-reputation" endpoints.
     * @return EReputation
     */
    public function getEReputation(): EReputation
    {
        return $this->eReputation;
    }
}
