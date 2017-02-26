<?php

namespace spec\Gpenverne\PutioDriveBundle\Service;

use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Routing\Router;

class UrlGeneratorSpec extends ObjectBehavior
{
    public function let(Router $router)
    {
        $router->generate('a-callback-route', [], true)->willReturn('http://a-full-url');

        $this->beConstructedWith($router, [
            'client_id' => 'a-client-id',
            'client_secret' => 'a-client-secret',
            'callback_route' => 'a-callback-route',
        ]);
    }

    public function it_returns_a_redirect_url()
    {
        $url = urlencode('http://a-full-url');

        $this->getRedirectUrl()->shouldReturn(
            sprintf('https://api.put.io/v2/oauth2/authenticate?client_id=a-client-id&response_type=code&redirect_uri=%s', $url)
        );
    }

    public function it_returns_a_token_url()
    {
        $url = urlencode('http://a-full-url');

        $this->getTokenUrl('a-code')->shouldReturn(
            sprintf('https://api.put.io/v2/oauth2/access_token?client_id=a-client-id&client_secret=a-client-secret&grant_type=authorization_code&redirect_uri=%s&code=a-code', $url)
        );
    }
}
