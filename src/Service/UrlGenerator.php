<?php

namespace Gpenverne\PutioDriveBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;

/**
 * @see https://put.io/v2/docs/gettingstarted.html#obtain-an-access-token-oauth-token
 */
class UrlGenerator
{
    const CODE_PARAMETER = 'code';

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
            $request->query->remove(self::CODE_PARAMETER);
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

        return sprintf($url, $this->params['client_id'], $this->params['redirect_uri']);
    }

    /**
     * @return string
     */
    public function getTokenUrl()
    {
        return 'https://api.put.io/v2/oauth2/access_token';
    }

    /**
     * @param string $code
     *
     * @return array
     */
    public function getTokenUrlParameters($code)
    {
        return [
            'client_id' => $this->params['client_id'],
            'client_secret' => $this->params['client_secret'],
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->params['redirect_uri'],
        ];
    }
}
