<?php

namespace spec\Gpenverne\PutioDriveBundle\Service;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;

class UrlGeneratorSpec extends ObjectBehavior
{
    public function let(Router $router, RequestStack $requestStack, Request $request)
    {
        $requestStack->getCurrentRequest()->willReturn($request);
        $router->generate('a-callback-route', [], Router::ABSOLUTE_URL)->willReturn('http://a-full-url');

        $this->beConstructedWith($router, $requestStack, [
            'client_id' => 'a-client-id',
            'client_secret' => 'a-client-secret',
            'callback_route' => 'a-callback-route',
        ]);
    }

    public function it_returns_a_redirect_url()
    {
        $url = 'http://a-full-url';

        $this->getRedirectUrl()->shouldReturn(
            sprintf('https://api.put.io/v2/oauth2/authenticate?client_id=a-client-id&response_type=code&redirect_uri=%s', $url)
        );
    }

    public function it_returns_a_token_url()
    {
        $this->getTokenUrl()->shouldReturn('https://api.put.io/v2/oauth2/access_token');
    }

    public function it_returns_token_url_parameters()
    {
        $this->getTokenUrlParameters('some-code')->shouldReturn([
            'client_id' => 'a-client-id',
            'client_secret' => 'a-client-secret',
            'grant_type' => 'authorization_code',
            'code' => 'some-code',
            'redirect_uri' => 'http://a-full-url',
        ]);
    }
}
