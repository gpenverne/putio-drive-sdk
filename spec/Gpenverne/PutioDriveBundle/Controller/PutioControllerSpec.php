<?php

namespace spec\Gpenverne\PutioDriveBundle\Controller;

use Gpenverne\PutioDriveBundle\Controller\PutioController;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Gpenverne\PutioDriveBundle\Event\PutioEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PutioControllerSpec extends ObjectBehavior
{
    public function let(EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($dispatcher);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioController::class);
    }

    public function it_redirects()
    {
        $this->redirectAction()->shouldHaveType(RedirectResponse::class);
    }

    public function it_dispatch_an_event($dispatcher)
    {
        $dispatcher->dispatch(PutioEvent::TOKEN_EVENT_NAME, Argument::Type(PutioEvent::class))->shouldBeCalled();
        $this->callbackAction();
    }
}
