<?php

declare(strict_types=1);

namespace Amadeus\DutyOfCare;

use Amadeus\Amadeus;
use Amadeus\DutyOfCare\Diseases\Covid19AreaReport;

/**
 * A namespaced client for the
 * "/v1/duty-of-care/diseases" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getDutyOfCare()->getDiseases();
 *
 */
class Diseases
{
    /**
     * A namespaced client for the
     * "/v1/duty-of-care/diseases/covid19-area-report" endpoints.
     */
    private Covid19AreaReport $covid19AreaReport;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->covid19AreaReport = new Covid19AreaReport($amadeus);
    }

    /**
     * A namespaced client for the
     * "/v1/duty-of-care/diseases/covid19-area-report" endpoints.
     * @return Covid19AreaReport
     */
    public function getCovid19AreaReport(): Covid19AreaReport
    {
        return $this->covid19AreaReport;
    }
}
