<?php

namespace Amadeus\Tests\Shopping;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\SeatMap;
use Amadeus\Shopping\SeatMaps;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

class SeatMapTest extends TestCase
{
    private $amadeus;

    private $client;

    /**
     * @before
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
     * @covers \Amadeus\Shopping\SeatMaps
     *
     * @return void
     * @throws ResponseException
     */
    public function test_post_seatmap_success()
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "seatmaps_post_response_ok.json"
        );
        $data4Post = json_decode($fileContent)->{'data'};
        $response4Post = $this->createMock(Response::class);
        $response4Post->expects($this->any())
            ->method("getData")
            ->willReturn($data4Post);

        // POST Parameters
        $body = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "seatmaps_post_request_ok.json"
        );

        $this->client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v1/shopping/seatmaps", $body)
            ->willReturn($response4Post);

        $seatmaps = new SeatMaps($this->amadeus);
        $seatmap = $seatmaps->post($body);

        // Null check
        $this->assertNotNull($seatmap);

        $this->assertTrue($seatmap[0] instanceof SeatMap);
        $this->assertEquals("seatmap", $seatmap[0]->getType());
    }
}