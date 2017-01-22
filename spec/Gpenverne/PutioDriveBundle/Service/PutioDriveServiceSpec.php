<?php

namespace spec\Gpenverne\PutioDriveBundle\Service;

use Gpenverne\PutioDriveBundle\Service\PutioDriveService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PutioDriveServiceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioDriveService::class);
    }
}
