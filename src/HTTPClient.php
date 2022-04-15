<?php

declare(strict_types=1);

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
     * @param string $path
     * @param array $query
     * @return Response
     * @throws ResponseException
     */
    public function getWithArrayParams(string $path, array $query): Response
    {
        $request = new Request(
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
    public function postWithStringBody(string $path, string $body): Response
    {
        $request = new Request(
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
        if ($this->accessToken!=null) {
            if ($this->accessToken->getExpiresAt() < time()) {
                //print_r('AccessToken expired!'."\n");
                // If expired then refresh the token
                $this->accessToken = $this->fetchAccessToken();
            }
        } else {
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
        $params = array(
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getClientSecret(),
            'grant_type' => 'client_credentials'
        );

        $request = new Request(
            Constants::POST,
            '/v1/security/oauth2/token',
            $params,
            null,
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
    protected function execute(Request $request): Response
    {
        $curlHandle = curl_init();
        $this->setCurlOptions($curlHandle, $request);
        $result = curl_exec($curlHandle);
        $info = curl_getinfo($curlHandle);
        curl_close($curlHandle);

        $response = new Response($request, $info, $result);
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

        if ($statusCode >= 500) {
            $exception = new ServerException($response);
        } elseif ($statusCode == 404) {
            $exception = new NotFoundException($response);
        } elseif ($statusCode == 401) {
            $exception = new AuthenticationException($response);
        } elseif ($statusCode == 400) {
            $exception = new ClientException($response);
        } elseif ($statusCode == 204) {
            return;
        } elseif ($statusCode != 200) {
            $exception = new ResponseException($response);
        }

        if ($exception != null) {
            // TODO: This function needs to be reviewed
            // Log the error into file
//            if ($this->configuration->getLogger() == true) {
//                if ($this->configuration->getMsgDestination()) {
//                    error_log($exception->__toString(), $this->configuration->getMsgType(), $this->configuration->getMsgDestination());
//                } else {
//                    error_log($exception->__toString(), $this->configuration->getMsgType());
//                }
//            }
            throw $exception;
        }
    }

    /**
     * @param mixed $curlHandle
     * @param Request $request
     * @return void
     */
    protected function setCurlOptions($curlHandle, Request $request): void
    {
        // Url
        curl_setopt($curlHandle, CURLOPT_URL, $request->getUri());

        // Header
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $request->getHeaders());

        // Transfer the return to string
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

        // Include the header in the output
        curl_setopt($curlHandle, CURLOPT_HEADER, true);

        if ($request->getSslCertificate() != null) {
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curlHandle, CURLOPT_CAINFO, $request->getSslCertificate());
        } else {
            //for debug only!
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        }

        if ($request->getVerb() == Constants::POST) {
            curl_setopt($curlHandle, CURLOPT_POST, true);
            if ($request->getBody() != null) {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $request->getBody());
            }
            if ($request->getParams() != null) {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($request->getParams()));
            }
        }
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function setSslCertificate(string $filePath)
    {
        $this->sslCertificate = $filePath;
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
