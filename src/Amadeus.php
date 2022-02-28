<?php declare(strict_types=1);

namespace Amadeus;

use GuzzleHttp\Client as HttpClient;
use JsonMapper;
use JsonMapper_Exception;
use function json_decode;

class Amadeus
{
    protected const BASE_URL = 'https://test.api.amadeus.com';

    public String $clientId;
    public String $clientSecret;

    public HttpClient $httpClient;

    protected Token $token;

    public Airport $airport;

    /**
     * @throws JsonMapper_Exception
     */
    public function __construct
    (
        string $clientId,
        string $clientSecret
    )
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;

        $this->httpClient = $this->createHttpClient();
        $this->token = $this->getToken();

        $this->airport = new Airport($this);
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function getToken(): Token
    {
        $response = $this->httpClient->post('/v1/security/oauth2/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ],
        ]);

        $result = json_decode($response->getBody()->__toString());

        //print_r($result->{'type'}); // case for how to get specific value

        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;

        return $mapper->map($result, new Token());
    }

    protected function createHttpClient(): HttpClient
    {
        return new HttpClient([
            'base_uri' => self::BASE_URL,
            'http_errors' => false,
            'verify' => '/CA/cacert.pem',
        ]);
    }

}