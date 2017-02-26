<?php

namespace spec\Gpenverne\PutioDriveBundle\Service;

use PhpSpec\ObjectBehavior;
use Gpenverne\PutioDriveBundle\Service\HttpClient;

class HttpClientSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(HttpClient::class);
    }
}
