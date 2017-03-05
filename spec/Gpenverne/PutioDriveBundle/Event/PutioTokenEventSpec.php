<?php

namespace spec\Gpenverne\PutioDriveBundle\Event;

use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\GenericEvent;

class PutioTokenEventSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('a-token');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioTokenEvent::class);
    }

    public function it_is_a_generic_event()
    {
        $this->shouldHaveType(GenericEvent::class);
    }

    public function it_returns_a_token()
    {
        $this->getToken()->shouldReturn('a-token');
    }
}
