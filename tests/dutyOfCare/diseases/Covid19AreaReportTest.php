<?php

declare(strict_types=1);

namespace Amadeus\Tests\DutyOfCare\Diseases;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\DutyOfCare\Diseases\Covid19AreaReport;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Area;
use Amadeus\Resources\AreaAccessRestriction;
use Amadeus\Resources\AreaPolicy;
use Amadeus\Resources\AreaRestriction;
use Amadeus\Resources\AreaVaccinated;
use Amadeus\Resources\Border;
use Amadeus\Resources\DatedQuarantineRestriction;
use Amadeus\Resources\DatedTracingApplicationRestriction;
use Amadeus\Resources\DeclarationDocuments;
use Amadeus\Resources\DiseaseCase;
use Amadeus\Resources\DiseaseDataSources;
use Amadeus\Resources\DiseaseInfection;
use Amadeus\Resources\DiseaseTestingRestriction;
use Amadeus\Resources\DiseaseVaccination;
use Amadeus\Resources\EntryRestriction;
use Amadeus\Resources\ExitRestriction;
use Amadeus\Resources\Link;
use Amadeus\Resources\MaskRestriction;
use Amadeus\Resources\Transportation;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\DutyOfCare\Diseases\Covid19AreaReport
 *
 * @covers \Amadeus\Resources\Area
 * @covers \Amadeus\Resources\AreaAccessRestriction
 * @covers \Amadeus\Resources\AreaPolicy
 * @covers \Amadeus\Resources\AreaRestriction
 * @covers \Amadeus\Resources\AreaVaccinated
 * @covers \Amadeus\Resources\Border
 * @covers \Amadeus\Resources\DatedQuarantineRestriction
 * @covers \Amadeus\Resources\DatedTracingApplicationRestriction
 * @covers \Amadeus\Resources\DeclarationDocuments
 * @covers \Amadeus\Resources\DiseaseAreaReport
 * @covers \Amadeus\Resources\DiseaseCase
 * @covers \Amadeus\Resources\DiseaseDataSources
 * @covers \Amadeus\Resources\DiseaseInfection
 * @covers \Amadeus\Resources\DiseaseTestingRestriction
 * @covers \Amadeus\Resources\DiseaseVaccination
 * @covers \Amadeus\Resources\EntryRestriction
 * @covers \Amadeus\Resources\ExitRestriction
 * @covers \Amadeus\Resources\Link
 * @covers \Amadeus\Resources\MaskRestriction
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Transportation
 *
 * @see https://developers.amadeus.com/self-service/category/covid-19-and-travel-safety/api-doc/travel-restrictions/api-reference
 */
final class Covid19AreaReportTest extends TestCase
{
    private Amadeus $amadeus;
    private HTTPClient $client;

    /**
     * @Before
     */
    public function setUp(): void
    {
        // Mock an Amadeus with HTTPClient
        $this->amadeus = $this->createMock(Amadeus::class);
        $this->client = $this->createMock(HTTPClient::class);
        $this->amadeus->expects($this->any())
            ->method("getClient")
            ->willReturn($this->client);
    }

    /**
     * @throws ResponseException
     */
    public function test_given_client_when_call_covid_19_area_report_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "covid_19_area_report_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["countryCode" => "US"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/duty-of-care/diseases/covid19-area-report", $params)
            ->willReturn($response);

        // When
        $covid19AreaReport = (new Covid19AreaReport($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($covid19AreaReport);

        // Resources
        // DiseaseAreaReport
        $this->assertNotNull($covid19AreaReport->getSummary());
        $this->assertEquals("Medium", $covid19AreaReport->getDiseaseRiskLevel());
        $this->assertNotNull($covid19AreaReport->getHotspots());
        $this->assertEquals("covid19-area-report", $covid19AreaReport->getType());

        // Area
        $area = $covid19AreaReport->getArea();
        $this->assertTrue($area instanceof Area);
        $this->assertEquals("United States of America", $area->getName());
        $this->assertEquals("US", $area->getIataCode());
        $this->assertEquals("Country", $area->getAreaType());

        // DiseaseInfection
        $diseaseInfection = $covid19AreaReport->getDiseaseInfection();
        $this->assertTrue($diseaseInfection instanceof DiseaseInfection);
        $this->assertEquals("2022-05-22", $diseaseInfection->getDate());
        $this->assertEquals("Extreme", $diseaseInfection->getLevel());
        $this->assertEquals(431.11, $diseaseInfection->getRate());
        $this->assertNotNull($diseaseInfection->getInfectionMapLink());

        // DiseaseCase
        $diseaseCases = $covid19AreaReport->getDiseaseCases();
        $this->assertTrue($diseaseCases instanceof DiseaseCase);
        $this->assertEquals("2022-05-31", $diseaseCases->getDate());
        $this->assertEquals(1007032, $diseaseCases->getDeaths());
        $this->assertEquals(84210808, $diseaseCases->getConfirmed());

        // DiseaseDataSources
        $dataSources = $covid19AreaReport->getDataSources();
        $this->assertTrue($dataSources instanceof DiseaseDataSources);
        $this->assertNotNull($dataSources->getCovidDashboardLink());
        $this->assertNotNull($dataSources->getGovernmentSiteLink());

        // AreaRestriction
        $areaRestrictions = $covid19AreaReport->getAreaRestrictions();
        $this->assertTrue($areaRestrictions[0] instanceof AreaRestriction);
        $this->assertEquals("2022-05-19", $areaRestrictions[0]->getDate());
        $this->assertNotNull($areaRestrictions[0]->getText());
        $this->assertEquals("Domestic Travel", $areaRestrictions[0]->getRestrictionType());

        // AreaAccessRestriction
        $areaAccessRestriction = $covid19AreaReport->getAreaAccessRestriction();
        $this->assertTrue($areaAccessRestriction instanceof AreaAccessRestriction);

        // Transportation
        $transportation = $areaAccessRestriction->getTransportation();
        $this->assertTrue($transportation instanceof Transportation);
        $this->assertEquals("2022-05-19", $transportation->getDate());
        $this->assertNotNull("", $transportation->getText());
        $this->assertEquals("FLIGHT", $transportation->getTransportationType());
        $this->assertEquals("No", $transportation->getIsBanned());

        // DeclarationDocuments
        $declarationDocuments = $areaAccessRestriction->getDeclarationDocuments();
        $this->assertTrue($declarationDocuments instanceof DeclarationDocuments);
        $this->assertEquals("2022-05-19", $declarationDocuments->getDate());
        $this->assertNotNull($declarationDocuments->getText());
        $this->assertEquals("Yes", $declarationDocuments->getDocumentRequired());
        $this->assertNotNull($declarationDocuments->getTravelDocumentationLink());

        // EntryRestriction
        $entry = $areaAccessRestriction->getEntry();
        $this->assertTrue($entry instanceof EntryRestriction);
        $this->assertEquals("2022-05-26", $entry->getDate());
        $this->assertNotNull($entry->getText());
        $this->assertEquals("Partial", $entry->getBan());
        $this->assertEquals("indef", $entry->getThroughDate());
        $this->assertNotNull($entry->getRules());
        $this->assertNotNull($entry->getExemptions());

        // Area, tested before
        $this->assertNotNull($entry->getBannedArea());

        // Border
        $border = $entry->getBorderBan();
        $this->assertTrue($border[0] instanceof Border);
        $this->assertEquals("maritimeBorderBan", $border[0]->getBorderType());
        $this->assertEquals("Partially Open", $border[0]->getStatus());

        // DiseaseTestingRestriction
        $diseaseTesting = $areaAccessRestriction->getDiseaseTesting();
        $this->assertTrue($diseaseTesting instanceof DiseaseTestingRestriction);
        $this->assertEquals("2022-05-19", $diseaseTesting->getDate());
        $this->assertNotNull($diseaseTesting->getText());
        $this->assertEquals("Yes", $diseaseTesting->getIsRequired());
        $this->assertEquals("BEFORE_TRAVEL, IN_TRANSIT", $diseaseTesting->getWhen());
        $this->assertEquals("Mandatory", $diseaseTesting->getRequirement());
        $this->assertNotNull($diseaseTesting->getRules());

        // DatedTracingApplicationRestriction
        $tracingApplication = $areaAccessRestriction->getTracingApplication();
        $this->assertTrue($tracingApplication instanceof DatedTracingApplicationRestriction);
        $this->assertEquals("2022-05-19", $tracingApplication->getDate());
        $this->assertEquals("No", $tracingApplication->getIsRequired());

        // DatedQuarantineRestriction
        $quarantineModality = $areaAccessRestriction->getQuarantineModality();
        $this->assertTrue($quarantineModality instanceof DatedQuarantineRestriction);
        $this->assertEquals("2022-05-19", $quarantineModality->getDate());
        $this->assertNotNull($quarantineModality->getText());
        $this->assertEquals("Some travellers", $quarantineModality->getEligiblePerson());
        $this->assertEquals("Self", $quarantineModality->getQuarantineType());
        $this->assertEquals(7, $quarantineModality->getDuration());
        $this->assertNotNull($quarantineModality->getRules());

        // MaskRestriction
        $mask = $areaAccessRestriction->getMask();
        $this->assertTrue($mask instanceof MaskRestriction);
        $this->assertEquals("2022-05-19", $mask->getDate());
        $this->assertNotNull($mask->getText());
        $this->assertEquals("Recommended", $mask->getIsRequired());

        // ExitRestriction
        $exit = $areaAccessRestriction->getExit();
        $this->assertTrue($exit instanceof ExitRestriction);
        $this->assertEquals("2022-05-19", $exit->getDate());
        $this->assertNotNull($exit->getText());
        $this->assertEquals("No", $exit->getSpecialRequirements());
        $this->assertNotNull($exit->getRulesLink());
        $this->assertEquals("No", $exit->getIsBanned());

        // DiseaseVaccination
        $diseaseVaccination = $areaAccessRestriction->getDiseaseVaccination();
        $this->assertTrue($diseaseVaccination instanceof DiseaseVaccination);
        $this->assertEquals("2022-05-24", $diseaseVaccination->getDate());
        $this->assertNotNull($diseaseVaccination->getText());
        $this->assertEquals("Yes", $diseaseVaccination->getIsRequired());
        $this->assertNotNull($diseaseVaccination->getReferenceLink());
        $this->assertIsArray($diseaseVaccination->getAcceptedCertificates());
        $this->assertIsArray($diseaseVaccination->getQualifiedVaccines());
        $this->assertEquals("Yes", $diseaseVaccination->getPolicy());
        $this->assertEquals("Entry Ban, Quarantine", $diseaseVaccination->getExemptions());

        // AreaPolicy
        $areaPolicy = $covid19AreaReport->getAreaPolicy();
        $this->assertTrue($areaPolicy instanceof AreaPolicy);
        $this->assertEquals("2022-05-19", $areaPolicy->getDate());
        $this->assertNotNull($areaPolicy->getText());
        $this->assertEquals("Distancing", $areaPolicy->getStatus());
        $this->assertEquals("2020-03-16", $areaPolicy->getStartDate());
        $this->assertEquals("indef", $areaPolicy->getEndDate());
        $this->assertNotNull($areaPolicy->getReferenceLink());

        // Link
        $relatedArea = $covid19AreaReport->getRelatedArea();
        $this->assertTrue($relatedArea[0] instanceof Link);
        $this->assertIsArray($relatedArea[0]->getMethods());
        $this->assertEquals("Parent", $relatedArea[0]->getRel());

        // AreaVaccinated
        $areaVaccinated = $covid19AreaReport->getAreaVaccinated();
        $this->assertTrue($areaVaccinated[0] instanceof AreaVaccinated);
        $this->assertEquals("2022-05-20", $areaVaccinated[0]->getDate());
        $this->assertEquals("oneDose", $areaVaccinated[0]->getVaccinationDoseStatus());
        $this->assertEquals(78.876, $areaVaccinated[0]->getPercentage());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data),
            $covid19AreaReport->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'area'}),
            $area->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'diseaseInfection'}),
            $diseaseInfection->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'diseaseCases'}),
            $diseaseCases->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'dataSources'}),
            $dataSources->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaRestrictions'}[0]),
            $areaRestrictions[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}),
            $areaAccessRestriction->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'transportation'}),
            $transportation->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'declarationDocuments'}),
            $declarationDocuments->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'entry'}),
            $entry->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'diseaseTesting'}),
            $diseaseTesting->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'tracingApplication'}),
            $tracingApplication->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'quarantineModality'}),
            $quarantineModality->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'mask'}),
            $mask->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'exit'}),
            $exit->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaAccessRestriction'}->{'diseaseVaccination'}),
            $diseaseVaccination->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaPolicy'}),
            $areaPolicy->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'relatedArea'}[0]),
            $relatedArea[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'areaVaccinated'}[0]),
            $areaVaccinated[0]->__toString()
        );
    }
}
