<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping\FlightOffers;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FareRules;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\Resource;
use Amadeus\Shopping\FlightOffers\Prediction;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\FlightOffers\Prediction
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightOffer
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-choice-prediction/api-reference
 */
final class PredictionTest extends TestCase
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
    public function test_given_client_when_call_flight_choice_prediction_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_choice_prediction_post_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $body = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_choice_prediction_post_request_ok.json"
        );
        $flightOffersArray = Resource::toResourceArray(
            json_decode($body)->{'data'},
            FlightOffer::class
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v2/shopping/flight-offers/prediction", $body)
            ->willReturn($response);

        // When
        $prediction = new Prediction($this->amadeus);
        $predictionResult1 = $prediction->post($body);
        $predictionResult2 = $prediction->postWithFlightOffers($flightOffersArray);

        // Then
        $this->assertNotNull($predictionResult1);
        $this->assertNotNull($predictionResult2);

        // Resource
        // FlightOffer
        // See FlightOffersTest.php
        $flightOffer = $predictionResult1[0];
        $this->assertEquals("0.5000000000000000", $flightOffer->getChoiceProbability());
    }
}
