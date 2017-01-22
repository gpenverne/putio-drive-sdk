<?php

namespace spec\Gpenverne\PutioDriveBundle\Service;

use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
use PhpSpec\ObjectBehavior;

class UrlGeneratorSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([
            'client_id' => 'a-client-id',
            'client_secret' => 'a-client-secret',
            'redirect_uri' => 'a-redirect-uri',
        ]);
    }

    public function it_returns_a_redirect_url()
    {
        $this->getRedirectUrl()->shouldReturn(
            'https://api.put.io/v2/oauth2/authenticate?client_id=a-client-id&response_type=code&redirect_uri=a-redirect-uri'
        );
    }

    public function it_returns_a_token_url()
    {
        $this->getTokenUrl('a-code')->shouldReturn(
            'https://api.put.io/v2/oauth2/access_token?client_id=a-client-id&client_secret=a-client-secret&grant_type=authorization_code&redirect_uri=a-redirect-uri&code=a-code'
        );
    }
}
