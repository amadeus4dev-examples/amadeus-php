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

    private $ch = null;

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
     * @param string $url
     * @param array $headers
     * @return void
     */
    private function setCurlOptions(string $url, array $headers): void
    {
        // Url
        curl_setopt($this->ch, CURLOPT_URL, $url);

        // Header
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);

        // Transfer the return to string
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        if($this->sslCertificate != null)
        {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($this->ch, CURLOPT_CAINFO, $this->sslCertificate);
        }
        else
        {
            //for debug only!
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        }
    }

    /**
     * @param string $path
     * @param array $query
     * @return Response
     * @throws ResponseException
     */
    public function get(string $path, array $query): Response
    {
        $url = $this->configuration->getBaseUrl().$path.'?'.http_build_query($query);
        $headers = $this->prepareHeaders();

        $this->ch = curl_init();
        $this->setCurlOptions($url, $headers);
        $result = json_decode(curl_exec($this->ch));
        $info = curl_getinfo($this->ch);
        curl_close($this->ch);

        $response = new Response($info, $result);
        $this->detectError($response);

        return $response;
    }

    /**
     * @param string $path
     * @param string $body
     * @return Response
     * @throws ResponseException
     */
    public function post(string $path, string $body): Response
    {
        $url = $this->configuration->getBaseUrl().$path;
        $headers = $this->prepareHeaders();
        if(in_array($path, Constants::API_NEED_EXTRA_HEADER))
        {
            $headers[] = "X-HTTP-Method-Override: GET";
        }

        $this->ch = curl_init();
        $this->setCurlOptions($url, $headers);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch,CURLOPT_POSTFIELDS, $body);
        $result = json_decode(curl_exec($this->ch));
        $info = curl_getinfo($this->ch);
        curl_close($this->ch);

        $response = new Response($info, $result);
        $this->detectError($response);

        return $response;
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
    public function fetchAccessToken(): AccessToken
    {
        $url = $this->configuration->getBaseUrl().'/v1/security/oauth2/token';
        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        );
        $data = array(
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getClientSecret(),
            'grant_type' => 'client_credentials'
        );

        $this->ch = curl_init();
        $this->setCurlOptions($url, $headers);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = json_decode(curl_exec($this->ch));
        $info = curl_getinfo($this->ch);
        curl_close($this->ch);

        $response = new Response($info,$result);
        $this->detectError($response);

        return new AccessToken($response->getResult());
    }

    /**
     * @param Response $response
     * @return void
     * @throws ResponseException
     */
    protected function detectError(Response  $response): void
    {
        $exception = null;
        $statusCode = $response->getInfo()->{'http_code'};

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
            throw $exception;
        }
    }

    /**
     * @return array
     * @throws ResponseException
     */
    private function prepareHeaders(): array
    {
        return array(
            'Accept: application/json, application/vnd.amadeus+json',
            'Authorization: Bearer ' .$this->getAuthorizedToken()->getAccessToken(),
            'Content-Type: application/vnd.amadeus+json',
        );
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }
}