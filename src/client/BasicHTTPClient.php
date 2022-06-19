<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Configuration;
use Amadeus\Constants;
use Amadeus\Exceptions\AuthenticationException;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\NetworkException;
use Amadeus\Exceptions\NotFoundException;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Exceptions\ServerException;

class BasicHTTPClient implements HTTPClient
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
        $this->accessToken = new AccessToken($this);
    }

    /**
     * @param string $path
     * @return Response
     * @throws ResponseException
     */
    public function getWithOnlyPath(string $path): Response
    {
        $request = new Request(
            Constants::GET,
            $path,
            null,
            null,
            $this->getAccessToken()->getBearerToken(),
            $this
        );

        return $this->execute($request);
    }

    /**
     * @param string $path
     * @param array $params
     * @return Response
     * @throws ResponseException
     */
    public function getWithArrayParams(string $path, array $params): Response
    {
        $request = new Request(
            Constants::GET,
            $path,
            $params,
            null,
            $this->getAccessToken()->getBearerToken(),
            $this
        );

        return $this->execute($request);
    }

    /**
     * @param string $path
     * @param string $body
     * @param array|null $params
     * @return Response
     * @throws ResponseException
     */
    public function postWithStringBody(string $path, string $body, ?array $params = null): Response
    {
        $request = new Request(
            Constants::POST,
            $path,
            $params,
            $body,
            $this->getAccessToken()->getBearerToken(),
            $this
        );

        return $this->execute($request);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ResponseException
     */
    public function execute(Request $request): Response
    {
        $curlHandle = curl_init();
        $this->setCurlOptions($curlHandle, $request);
        $result = curl_exec($curlHandle);
        if (!$result) {
            $result = null;
        }
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
    protected function detectError(Response $response): void
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
        } elseif ($statusCode == 0) {
            $exception = new NetworkException($response);
        } elseif ($statusCode == 204) {
            return;
        } elseif ($statusCode == 201) {
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
            error_log($exception->__toString());

            // Log the error to console
            file_put_contents(
                'php://stdout',
                $exception->__toString()
            );

            throw $exception;
        }
    }

    /**
     * @param mixed $curlHandle
     * @param Request $request
     * @return void
     */
    private function setCurlOptions($curlHandle, Request $request): void
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
            } elseif ($request->getParams() != null) {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($request->getParams()));
            }
        }
    }

    /**
     * @return AccessToken|null
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
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
    public function getSSLCertificate(): ?string
    {
        return $this->sslCertificate;
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function setSSLCertificate(string $filePath): void
    {
        $this->sslCertificate = $filePath;
    }
}
