<?php

namespace spec\Gpenverne\PutioDriveBundle\Event;

use Symfony\Component\EventDispatcher\GenericEvent;
use Gpenverne\PutioDriveBundle\Event\PutioCodeEvent;
use PhpSpec\ObjectBehavior;

class PutioCodeEventSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('a-code');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioCodeEvent::class);
    }

    public function it_is_a_generic_event()
    {
        $this->shouldHaveType(GenericEvent::class);
    }
    public function it_returns_a_code()
    {
        $this->getCode()->shouldReturn('a-code');
    }
}
