<?php

declare(strict_types=1);

namespace Amadeus\DutyOfCare;

use Amadeus\Amadeus;
use Amadeus\DutyOfCare\Diseases\Covid19AreaReport;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/duty-of-care/diseases</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getDutyOfCare()->getDiseases();
 * </code>
 */
class Diseases
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/duty-of-care/diseases/covid19-area-report</code> endpoints.
     * </p>
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
     * <p>
     *   A namespaced client for the
     *   <code>/v1/duty-of-care/diseases/covid19-area-report</code> endpoints.
     * </p>
     * @return Covid19AreaReport
     */
    public function getCovid19AreaReport(): Covid19AreaReport
    {
        return $this->covid19AreaReport;
    }
}
