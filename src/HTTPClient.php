<?php declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\AccessToken;
use Amadeus\Exceptions\AuthenticationException;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\NotFoundException;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Exceptions\ServerException;

class HTTPClient
{
    protected ?AccessToken $accessToken = null;

    private Configuration $configuration;

    private ?string $sslCertificate = null;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function setSslVerify(string $filePath)
    {
        $this->sslCertificate = $filePath;
    }

    /**
     * @param string $path
     * @param array $query
     * @return Response
     * @throws ResponseException
     */
    public function get(string $path, array $query): Response
    {
        $request = new Request(
            curl_init(),
            Constants::GET,
            $path,
            $query,
            null,
            $this->getAuthorizedToken()->getAccessToken(),
            $this
        );

        return $this->execute($request);
    }

    /**
     * @param string $path
     * @param string $body
     * @return Response
     * @throws ResponseException
     */
    public function post(string $path, string $body): Response
    {
        $request = new Request(
            curl_init(),
            Constants::POST,
            $path,
            null,
            $body,
            $this->getAuthorizedToken()->getAccessToken(),
            $this
        );

        return $this->execute($request);
    }

    /**
     * @throws ResponseException
     */
    public function getAuthorizedToken(): AccessToken
    {
        $this->updateAccessToken();
        return $this->accessToken;
    }

    /**
     * @throws ResponseException
     */
    protected function updateAccessToken(): void
    {
        // Checks if the current access token expires.
        if($this->accessToken!=null){
            if($this->accessToken->getExpiresAt() < time()){
                //print_r('AccessToken expired!'."\n");
                // If expired then refresh the token
                $this->accessToken = $this->fetchAccessToken();
            }
        }else{
            // Else still return the current token
            //print_r("First time to fetch AccessToken!"."\n");
            $this->accessToken = $this->fetchAccessToken();
        }
    }

    /**
     * @throws ResponseException
     */
    protected function fetchAccessToken(): AccessToken
    {
        $data = array(
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getClientSecret(),
            'grant_type' => 'client_credentials'
        );

        $request = new Request(
            curl_init(),
            Constants::POST,
            '/v1/security/oauth2/token',
            null,
            http_build_query($data),
            null,
            $this
        );

        $response = $this->execute($request);

        return new AccessToken($response->getBodyAsJsonObject());
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ResponseException
     */
    private function execute(Request $request): Response
    {
        $result = curl_exec($request->getCurlHandle());
        $info = curl_getinfo($request->getCurlHandle());
        curl_close($request->getCurlHandle());

        $response = new Response($info, $result);
        $this->detectError($response);

        return $response;
    }

    /**
     * @param Response $response
     * @return void
     * @throws ResponseException
     */
    protected function detectError(Response  $response): void
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
            // Log the error into file
            if($this->configuration->getLogger() == true)
            {
                if($this->configuration->getMsgDestination())
                {
                    error_log($exception->__toString(), $this->configuration->getMsgType(), $this->configuration->getMsgDestination());
                }
                else
                {
                    error_log($exception->__toString(), $this->configuration->getMsgType());
                }
            }
            throw $exception;
        }
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return string|null
     */
    public function getSslCertificate(): ?string
    {
        return $this->sslCertificate;
    }
}