<?php

declare(strict_types=1);

namespace Amadeus\Tests\Booking;

use Amadeus\Amadeus;
use Amadeus\Booking\FlightOrders;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\FlightOrder;
use Amadeus\Resources\FlightOrderAssociatedRecord;
use Amadeus\Resources\Resource;
use Amadeus\Resources\TravelerContact;
use Amadeus\Resources\TravelerDocuments;
use Amadeus\Resources\TravelerElement;
use Amadeus\Resources\TravelerName;
use Amadeus\Resources\TravelerPhone;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Booking\FlightOrders
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightOrder
 * @covers \Amadeus\Resources\FlightOrderAssociatedRecord
 * @covers \Amadeus\Resources\FlightOffer
 * @covers \Amadeus\Resources\TravelerElement
 * @covers \Amadeus\Resources\TravelerName
 * @covers \Amadeus\Resources\TravelerContact
 * @covers \Amadeus\Resources\TravelerPhone
 * @covers \Amadeus\Resources\TravelerDocuments
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-create-orders/api-reference
 */
final class FlightOrdersTest extends TestCase
{
    private Amadeus $amadeus;
    private string $body;
    private array $flightOffers;
    private array $travelers;
    private object $data;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $this->amadeus = $this->createMock(Amadeus::class);
        $client = $this->createMock(HTTPClient::class);
        $this->amadeus->expects($this->any())
            ->method("getClient")
            ->willReturn($client);

        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_orders_post_response_ok.json"
        );
        $this->data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($this->data);

        // Given
        $this->body = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_orders_post_request_ok.json"
        );
        $this->flightOffers = Resource::toResourceArray(
            json_decode($this->body)->{'data'}->{'flightOffers'},
            FlightOffer::class
        );
        $this->travelers = Resource::toResourceArray(
            json_decode($this->body)->{'data'}->{'travelers'},
            TravelerElement::class
        );
        $client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v1/booking/flight-orders", $this->body)
            ->willReturn($response);
    }

    /**
     * @throws ResponseException
     */
    public function testEndpoint(): void
    {
        // When
        $flightOrders = new FlightOrders($this->amadeus);
        $flightOrderOutput = $flightOrders->post($this->body);
        $flightOrderOutput2 = $flightOrders->postWithFlightOffersAndTravelers($this->flightOffers, $this->travelers);

        // Then
        $this->assertNotNull($flightOrderOutput);
        $this->assertNotNull($flightOrderOutput2);

        // Resource
        // FlightOrder
        $this->assertTrue($flightOrderOutput instanceof FlightOrder);
        $this->assertEquals("flight-order", $flightOrderOutput->getType());
        $this->assertEquals("MlpZVkFMfFdBVFNPTnwyMDE1LTExLTAy", $flightOrderOutput->getId());
        $this->assertEquals("NCE1A0950", $flightOrderOutput->getQueuingOfficeId());

        // FlightOrderAssociatedRecord
        $associatedRecords = $flightOrderOutput->getAssociatedRecords();
        $this->assertTrue($associatedRecords[0] instanceof FlightOrderAssociatedRecord);
        $this->assertEquals("2ZYVAL", $associatedRecords[0]->getReference());
        $this->assertEquals("2018-07-13T20:17:00", $associatedRecords[0]->getCreationDateTime());
        $this->assertEquals("1A", $associatedRecords[0]->getOriginSystemCode());
        $this->assertEquals("1", $associatedRecords[0]->getFlightOfferId());

        // TravelerElement
        $travelers = $flightOrderOutput->getTravelers();
        $this->assertTrue($travelers[0] instanceof TravelerElement);
        $this->assertEquals("1", $travelers[0]->getId());
        $this->assertEquals("1982-01-16", $travelers[0]->getDateOfBirth());

        // TravelerName
        $name = $travelers[0]->getName();
        $this->assertTrue($name instanceof TravelerName);
        $this->assertEquals("STEPHANE", $name->getFirstName());
        $this->assertEquals("MARTIN", $name->getLastName());

        // TravelerContact
        $contact = $travelers[0]->getContact();
        $this->assertTrue($contact instanceof TravelerContact);

        // TravelerPhone
        $phones = $contact->getPhones();
        $this->assertTrue($phones[0] instanceof TravelerPhone);
        $this->assertEquals("33", $phones[0]->getCountryCallingCode());
        $this->assertEquals("487692704", $phones[0]->getNumber());

        // TravelerDocuments
        $documents = $travelers[0]->getDocuments();
        $this->assertTrue($documents[0] instanceof TravelerDocuments);
        $this->assertEquals("PASSPORT", $documents[0]->getDocumentType());
        $this->assertEquals("012345678", $documents[0]->getNumber());
        $this->assertEquals("2009-04-14", $documents[0]->getExpiryDate());
        $this->assertEquals("GB", $documents[0]->getIssuanceCountry());
        $this->assertEquals("GB", $documents[0]->getNationality());
        $this->assertEquals(true, $documents[0]->getHolder());

        // FlightOffer
        $flightOffers = $flightOrderOutput->getFlightOffers();
        $this->assertNotNull($flightOffers);

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($this->data),
            $flightOrderOutput->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data->{'associatedRecords'}[0]),
            $associatedRecords[0]->__toString()
        );
        $this->assertEquals(
            strlen(PHPUnitUtil::toString($this->data->{'travelers'}[0])),
            strlen($travelers[0]->__toString())
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data->{'travelers'}[0]->{'name'}),
            $name->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data->{'travelers'}[0]->{'contact'}),
            $contact->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data->{'travelers'}[0]->{'contact'}->{'phones'}[0]),
            $phones[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data->{'travelers'}[0]->{'documents'}[0]),
            $documents[0]->__toString()
        );
    }
}
