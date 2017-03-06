<?php

namespace Gpenverne\PutioDriveBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;

class UrlGenerator
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param Router $router
     * @param array  $params
     */
    public function __construct(Router $router, RequestStack $requestStack, $params)
    {
        $this->params = $params;
        $request = $requestStack->getCurrentRequest();

        if (null !== $request && null !== $request->query) {
            $routeParams = $request->query->all();
        } else {
            $routeParams = [];
        }

        $this->params['redirect_uri'] = $router->generate($params['callback_route'], $routeParams, Router::ABSOLUTE_URL);
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        $url = 'https://api.put.io/v2/oauth2/authenticate?client_id=%s&response_type=code&redirect_uri=%s';

        return sprintf($url, $this->params['client_id'], urlencode($this->params['redirect_uri']));
    }

    /**
     * @return string
     */
    public function getTokenUrl($code)
    {
        $url = 'https://api.put.io/v2/oauth2/access_token?client_id=%s&client_secret=%s&grant_type=authorization_code&redirect_uri=%s&code=%s';

        return sprintf($url, $this->params['client_id'], $this->params['client_secret'], urlencode($this->params['redirect_uri']), $code);
    }
}
