<?php

namespace spec\Gpenverne\PutioDriveBundle\Service;

use Gpenverne\PutioDriveBundle\Service\PutioDriveService;
use PhpSpec\ObjectBehavior;

class PutioDriveServiceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioDriveService::class);
    }

    public function it_sets_a_token()
    {
        $this->getToken()->shouldReturn(null);

        $this->setToken('a-token')->shouldReturn($this);
        $this->getToken('a-token');
    }
}
