<?php declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\AccessToken;
use Amadeus\Exceptions\AuthenticationException;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\NotFoundException;
use Amadeus\Exceptions\ServerException;
use Exception;
use JsonMapper;
use JsonMapper_Exception;

class HTTPClient
{
    protected AccessToken $accessToken;

    private Configuration $configuration;

    /**
     * @param Configuration $configuration
     * @throws JsonMapper_Exception
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->accessToken = $this->fetchAccessToken();
    }

    /**
     * @param $ch
     * @param string $url
     * @param array $headers
     * @return void
     */
    private function setCurlOptions($ch, string $url, array $headers): void
    {
        // Url
        curl_setopt($ch, CURLOPT_URL, $url);

        // Header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Transfer the return to string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, "/CA/cacert.pem");
    }

    /**
     * @param string $path
     * @param array $query
     * @return Response
     * @throws JsonMapper_Exception
     */
    public function get(string $path, array $query): Response
    {
        $url = $this->configuration->getBaseUrl().$path.'?'.http_build_query($query);
        $headers = $this->prepareHeaders();

        $ch = curl_init();
        $this->setCurlOptions($ch, $url, $headers);
        $result = json_decode(curl_exec($ch));
        $info = curl_getinfo($ch);
        curl_close($ch);

        $response = new Response($info, $result);
        $this->detectError($response);

        return $response;
    }

    /**
     * @param string $path
     * @param string $body
     * @return Response
     * @throws JsonMapper_Exception
     */
    public function post(string $path, string $body): Response
    {
        $url = $this->configuration->getBaseUrl().$path;
        $headers = $this->prepareHeaders();

        $ch = curl_init();
        $this->setCurlOptions($ch, $url, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $body);
        $result = json_decode(curl_exec($ch));
        $info = curl_getinfo($ch);
        curl_close($ch);

        $response = new Response($info, $result);
        $this->detectError($response);

        return $response;
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
        $url = $this->configuration->getBaseUrl().'/v1/security/oauth2/token';
        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        );
        $data = array(
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getClientSecret(),
            'grant_type' => 'client_credentials'
        );

        $ch = curl_init();
        $this->setCurlOptions($ch, $url, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = json_decode(curl_exec($ch));
        $info = curl_getinfo($ch);
        curl_close($ch);

        $response = new Response($info,$result);
        $this->detectError($response);

        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;
        return $mapper->map($response->getResult(), new AccessToken());
    }

    /**
     * @param Response response
     * @return void
     */
    protected function detectError(Response  $response): void
    {
        $exception = null;
        $statusCode = $response->getInfo()['http_code'];

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
     * @return array
     * @throws JsonMapper_Exception
     */
    private function prepareHeaders(): array
    {
        return array(
            'Accept: application/json, application/vnd.amadeus+json',
            'Authorization: Bearer ' .$this->getAuthorizedToken()->getAccessToken(),
            'Content-Type: application/vnd.amadeus+json'
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