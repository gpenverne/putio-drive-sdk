<?php

namespace Gpenverne\PutioDriveBundle\Service;

class UrlGenerator
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        $url = 'https://api.put.io/v2/oauth2/authenticate?client_id=%s&response_type=code&redirect_uri=%s';
        return sprintf($url, $this->params['client_id'], $this->params['redirect_uri']);
    }

    /**
     * @return string
     */
    public function getTokenUrl(string $code)
    {
        $url = 'https://api.put.io/v2/oauth2/access_token?client_id=%s&client_secret=%s&grant_type=authorization_code&redirect_uri=%s&code=%s';
        return sprintf($url, $this->params['client_id'], $this->params['client_secret'], $this->params['redirect_uri'], $code);
    }
}
