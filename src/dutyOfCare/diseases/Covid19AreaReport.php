<?php

declare(strict_types=1);

namespace Amadeus\DutyOfCare\Diseases;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\DiseaseAreaReport;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/duty-of-care/diseases/covid19-area-report" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getDutyOfCare()->getDiseases()->getCovid19AreaReport();
 *
 */
class Covid19AreaReport
{
    private Amadeus $amadeus;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * Travel Restrictions API:
     *
     * Get up-to-date data on COVID-19 caseloads and travel restrictions
     * for a given country, city or region.
     *
     *      $amadeus->getDutyOfCare()->getDiseases()->getCovid19AreaReport()->get(["countryCode"=>"US"]);
     *
     * @link https://developers.amadeus.com/self-service/category/covid-19-and-travel-safety/api-doc/travel-restrictions/api-reference
     *
     * @param   array $params       the parameters to send to the API
     * @return  DiseaseAreaReport   an API resource
     * @throws  ResponseException   when an exception occurs
     */
    public function get(array $params): object
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/duty-of-care/diseases/covid19-area-report',
            $params
        );

        return Resource::fromObject($response, DiseaseAreaReport::class);
    }
}
