<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus;

class Token
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


    public function getHeader(): string
    {
        return $this->getTokenType() . ' ' . $this->getAccessToken();
    }

}