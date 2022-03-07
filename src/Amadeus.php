<?php declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\AccessToken;
use GuzzleHttp\Client as HttpClient;
use JsonMapper;
use JsonMapper_Exception;
use function json_decode;

class Amadeus
{
    protected const BASE_URL = 'https://test.api.amadeus.com';

    private Configuration $configuration;

    private AccessToken $accessToken;

    public HttpClient $httpClient;

    public Airport $airport;

    public Shopping $shopping;

    /**
     * @throws JsonMapper_Exception
     */
    public function __construct
    (
        Configuration $configuration
    )
    {
        $this->configuration = $configuration;

        $this->httpClient = $this->createHttpClient();
        $this->accessToken = $this->fetchAccessToken();

        $this->airport = new Airport($this);
        $this->shopping = new Shopping($this);
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return AccessToken
     * @throws JsonMapper_Exception
     */
    public function getAuthorizedToken(): AccessToken
    {
        // Checks if the current access token expires.
        if($this->accessToken->getExpiresAt() < time()){
            print_r('AccessToken expired!');
            // If expired then refresh the token
            return $this->fetchAccessToken();
        }else{
            // Else still return the current token
            return $this->accessToken;
        }
    }

    /**
     * @param string $path
     * @param array $query
     * @return object
     */
    public function get(string $path, array $query): object
    {
        $headers = array(
            'Content-Type' => 'application/vnd.amadeus+json',
            'Accept'=> 'application/json, application/vnd.amadeus+json',
            'Authorization' => $this->accessToken->getHeader(),
        );

        $response = $this->httpClient->get(
            $path,[
            'headers' => $headers,
            'query' => $query,
        ]);

        return json_decode($response->getBody()->__toString());
    }

    /**
     * @param string $path
     * @param string $body
     * @return object
     */
    public function post(string $path, string $body): object
    {
        $headers = array(
            'Content-Type' => 'application/vnd.amadeus+json',
            'Accept'=> 'application/json, application/vnd.amadeus+json',
            'Authorization' => $this->accessToken->getHeader()
        );

        $response = $this->httpClient->post(
            $path,[
            'headers' => $headers,
            'body' => $body,
        ]);

        return json_decode($response->getBody()->__toString());
    }

    /**
     * @return AccessToken
     * @throws JsonMapper_Exception
     */
    protected function fetchAccessToken(): AccessToken
    {
        $response = $this->httpClient->post('/v1/security/oauth2/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->configuration->getClientId(),
                    'client_secret' => $this->configuration->getClientSecret(),
                ],
        ]);

        $result = json_decode($response->getBody()->__toString());

        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;

        return $mapper->map($result, new AccessToken());
    }

    /**
     * @return HttpClient
     */
    protected function createHttpClient(): HttpClient
    {
        return new HttpClient([
            'base_uri' => self::BASE_URL,
            'http_errors' => false,
            'verify' => '/CA/cacert.pem',
        ]);
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return Configuration
     */
    public static function builder(string $clientId, string $clientSecret): Configuration
    {
        return new Configuration($clientId,$clientSecret);
    }

}