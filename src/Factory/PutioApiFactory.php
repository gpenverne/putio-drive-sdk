<?php
namespace Gpenverne\PutioDriveBundle\Factory;

use PutIO\API;

class PutioApiFactory
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var API
     */
    private $api;

    /**
     * @param  string $token
     *
     * @return API
     */
    public function getApiClient($token = null)
    {
        return $this->createApiClient($token ? $token : $this->getToken());
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        if (null !== $this->api) {
            $this->createApiClient($token);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param  string $token
     * @return API
     */
    private function createApiClient($token)
    {
        $this->api = new API($token);

        return $this->api;
    }
}
