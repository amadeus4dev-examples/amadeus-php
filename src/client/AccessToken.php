<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Client;

class AccessToken
{
    private string $type;
    private string $username;
    private string $application_name;
    private string $client_id;
    private string $token_type;
    private string $access_token;
    private int $expires_in;
    private string $state;
    private string $scope;
    private int $expires_at;

    /**
     *
     */
    public function __construct()
    {
        // Renew the token 10 seconds earlier than required
        // Cuz the token will expire in 1799 seconds
        $this->expires_at = time()+1789;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getApplicationName(): string
    {
        return $this->application_name;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->client_id;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->token_type;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expires_in;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @return int
     */
    public function getExpiresAt(): int
    {
        return $this->expires_at;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->getTokenType() . ' ' . $this->getAccessToken();
    }


}