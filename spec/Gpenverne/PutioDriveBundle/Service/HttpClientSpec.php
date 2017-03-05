<?php

namespace spec\Gpenverne\PutioDriveBundle\Service;

use Gpenverne\PutioDriveBundle\Service\HttpClient;
use PhpSpec\ObjectBehavior;

class HttpClientSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(HttpClient::class);
    }
}
