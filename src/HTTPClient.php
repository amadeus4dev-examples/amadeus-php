<?php declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\AccessToken;
use Amadeus\Exceptions\AuthenticationException;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\NotFoundException;
use Amadeus\Exceptions\ServerException;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use JsonMapper;
use JsonMapper_Exception;
use Psr\Http\Message\ResponseInterface;

class HTTPClient
{
    protected const BASE_URL = 'https://test.api.amadeus.com';

    protected GuzzleHttpClient $httpClient;

    protected AccessToken $accessToken;

    private Configuration $configuration;

    /**
     * @param Configuration $configuration
     * @throws JsonMapper_Exception
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;

        $this->httpClient = $this->createHttpClient();
        $this->accessToken = $this->fetchAccessToken();
    }

    /**
     * @param string $path
     * @param array $query
     * @return object
     * @throws JsonMapper_Exception
     */
    public function get(string $path, array $query): object
    {
        $options = Options::optionsParams4GET(
            $query,$this->getAuthorizedToken()->getAccessToken()
        );
        $response = $this->httpClient->get($path, $options);
        $this->detectError($response);
        return json_decode($response->getBody()->__toString());
    }

    /**
     * @param string $path
     * @param string $body
     * @return object
     * @throws JsonMapper_Exception
     */
    public function post(string $path, string $body): object
    {
        $options = Options::optionsBody4POST(
            $body, $this->getAuthorizedToken()->getAccessToken()
        );
        $response = $this->httpClient->post($path, $options);
        $this->detectError($response);
        return json_decode($response->getBody()->__toString());
    }

    /**
     * @return AccessToken
     * @throws JsonMapper_Exception
     */
    public function getAuthorizedToken(): AccessToken
    {
        // Checks if the current access token expires.
        if($this->accessToken->getAccessToken()!=null){
            if($this->accessToken->getExpiresAt() < time()){
                print_r('AccessToken expired!');
                // If expired then refresh the token
                return $this->fetchAccessToken();
            }else{
                // Else still return the current token
                return $this->accessToken;
            }
        }else{
            // Else still return the current token
            return $this->fetchAccessToken();
        }
    }

    /**
     * @return AccessToken
     * @throws JsonMapper_Exception
     * @throws Exception
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
        $this->detectError($response);
        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;
        return $mapper->map(json_decode($response->getBody()->__toString()), new AccessToken());
    }

    /**
     * @return GuzzleHttpClient
     */
    protected function createHttpClient(): GuzzleHttpClient
    {
        return new GuzzleHttpClient([
            'base_uri' => self::BASE_URL,
            'http_errors' => false,
            'verify' => '/CA/cacert.pem',
        ]);
    }


    /**
     * @param ResponseInterface $response
     * @return void
     */
    protected function detectError(ResponseInterface $response): void
    {
        $exception = null;
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 500)
        {
            $exception = new ServerException($response);
        }
        else if ($statusCode == 404)
        {
            $exception = new NotFoundException($response);
        }
        else if ($statusCode == 401)
        {
            $exception = new AuthenticationException($response);
        }
        else if ($statusCode == 400)
        {
            $exception = new ClientException($response);
        }
        else if ($statusCode == 204)
        {
            return;
        }

        if ($exception != null)
        {
            echo $exception->__toString();
            echo "Trace:\n" . $exception->getTraceAsString();
        }
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }
}